<?php

class Klein {
    public $code;

    function __construct($html) {
        $pattern = array_map(function ($grammar) {
            list(, $result) = $grammar;
            $body = strtr($grammar[0], [' ' => "\s*", '+' => "\s+", ':var' => "(\w+(\s*\.\s*\w+)*)", ':id' => "(\w+)", '{{' => "{{\!?"]);
            return ["/$body/",
                function ($x) use ($result) {
                    $code = "<?php " . preg_replace_callback("/#(\d+)(s?)/", function ($s) use($x) {
                            $pref = $s[2] == 's' ? '$' : '';
                            return implode(", ", array_map(function ($s) use($pref) {
                                $list = preg_split('/\.\s*/', $s);
                                $first = array_shift($list);
                                
                                return count($list) > 0 ? "Klein::get(".$pref.$first.", [".implode(",", array_map(function ($x) { return "'$x'"; }, $list))."])" : $pref.$first; 
                            }, preg_split("/\s*,\s*/", $x[$s[1]])));
                        }, $result) . " ?>";
                    return ($x[0][2] == '!') ? "<!-- $code -->" : $code;
                }];
        }, [
            ["{% for+:id+in+:var %}", "foreach(#2s as \$index => #1s): \$loop = Klein::loop(\$index, #2s);"],
            ["{% for+:id , :id+in+:var %}", "foreach(#3s as #1s => #2s):"],
            ["{% endfor %}", "endforeach;"],
            ["{% if+:var = :var %}", "if(#1s === #3s):"],
            ["{% ifset+:var %}", "if(#1s !== null):"],
            ["{% if+:var %}", "if(#1s !== null && #1s):"],
            ["{% if+:id \(( :var (, :var )*)?\) %}", "if(macro_#1(#2s)):"],
            ["{% unless+:var %}", "if(!(#1s !== null && #1s)):"],
            ["{% else %}", "else:"],
            ["{% endif %}", "endif;"],
            ["{{ :var }}", "echo #1s;"],
            ["{% :id \(( :var (, :var )*)?\) %}", "echo macro_#1(#2s);"],
            ["{{ :var\|:id }}", "echo #3(#1s);"],
            ["{% macro+:id \(( :id (, :id )*)?\) %}", "function macro_#1(#2s) {"],
            ["{% endmacro %}", "}"]
        ]);

        $result = file_get_contents($html);
        foreach($pattern as $arg) {
            $result = preg_replace_callback($arg[0], $arg[1], $result);
        }

        $this->code = $result;
    }

    static function get($arr, $items) {
        $result = $arr;
        foreach ($items as $key) {
            if (is_array($result)) {
                $result = isset($result[$key]) ? $result[$key] : null;
            } else {
                $result = isset($result->{$key}) ? $result->{$key} : null;
            }
        }
        return $result;
    }

    static function loop($idx, &$array) {
        $is_even =  $idx % 2;
        return ['first' => $idx == 0
            , 'last' => $idx == count($array) - 1
            , 'odd' => !$is_even
            , 'even' => $is_even];
    }

    function render($vars) {
        extract($vars);
        ob_start();
        eval(" ?>".$this->code."<?php ");
        return ob_get_clean();
    }
}
