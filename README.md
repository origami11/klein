# Простой шаблонизатор

Для подсветки синтаксиса в редакторах можно выбрать Twig или Django

# Переменные

Для переменной name=Ivan шаблон
```html
<b>Hello, {{ name }}</div>
```
преобразуется в 
```html
<b>Hello, Ivan</div>
```

```html
<b>Hello, {{! name }} </div>
```
преобразуется в 
```html
<b>Hello, <!-- Ivan --></div>
```

# Циклы

```html
<ul>
    {% for user in users %}
        <li>Hello, {{ user.name }}</li>
    {% endfor %}
</ul>
```

# Условия

```html
<ul>
    {% for user in users %}
        {% if user.is_russian %}
            <li>Привет, {{ user.name }}</li>
        {% else %}
            <li>Hello, {{ user.name }}</li>
        {% endif %}
    {% endfor %}
</ul>
```

# Макрос

```html
{% macro hello(user) %}
    {% if user.is_russian %}
        <li>Привет, {{ user.name }}</li>
    {% else %}
        <li>Hello, {{ user.name }}</li>
    {% endif %}
{% endmacro %}
<ul>
    {% for user in users %}
        {{ hello(user) }}
    {% endfor %}
</ul>
```