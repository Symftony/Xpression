<div class="content">
    <ul class="example">
        <li><a href="?query={title='foo'}">title = 'foo'</a></li>
        <li><a href="?query={price=10}">price = 10</a></li>
        <li><a href="?query={price≠10}">price ≠ 10</a></li>
        <li><a href="?query={price>10}">price > 10</a></li>
        <li><a href="?query={price≥10}">price ≥ 10</a></li>
        <li><a href="?query={price<10}">price < 10</a></li>
        <li><a href="?query={price≤10}">price ≤ 10</a></li>
        <li><a href="?query={price>10&price<20}">price > 10 & price < 20</a></li>
        <li><a href="?query={price=2|category='food'}">price=2 | category = 'food'</a></li>
        <li><a href="?query={price>10&category[1,5,7]}">price > 10 & category[1,5,7]</a></li>
        <li><a href="?query={title=foo|price>3&price<5}">title = foo | price > 3 & price < 5</a></li>
        <li><a href="?query={(title=foo|price>3)&price<5}">( title = foo | price > 3 ) & price < 5</a></li>
        <li><a href="?query={category[1,5,7]}">category[1,5,7]</a></li>
        <li><a href="?query={category![1,5,7]}">category![1,5,7]</a></li>
        <li class="error"><a href="?query={pr$ice}">Lexer error</a></li>
        <li class="error"><a href="?query={price]}">Parser error</a></li>
    </ul>
</div>
