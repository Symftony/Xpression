<div class="content">
    <ul class="example">
        <li><a href="?">title is null</a></li>
        <li><a href="?title='foo'">title = 'foo'</a></li>
        <li><a href="?price=10">price = 10</a></li>
        <li><a href="?price≠10">price ≠ 10</a></li>
        <li><a href="?price>10">price > 10</a></li>
        <li><a href="?price≥10">price ≥ 10</a></li>
        <li><a href="?price<10">price < 10</a></li>
        <li><a href="?price≤10">price ≤ 10</a></li>
        <li><a href="?price>10&price<20">price > 10 & price < 20</a></li>
        <li><a href="?price=2|category='food'">price=2 | category = 'food'</a></li>
        <li><a href="?price>10&category[1,5,7]">price > 10 & category[1,5,7]</a></li>
        <li><a href="?title=foo|price>3&price<5">title = foo | price > 3 & price < 5</a></li>
        <li><a href="?(title=foo|price>3)&price<5">( title = foo | price > 3 ) & price < 5</a></li>
        <li><a href="?category[1,5,7]">category[1,5,7]</a></li>
        <li><a href="?category![1,5,7]">category![1,5,7]</a></li>
        <li class="error"><a href="?pr$ice">Lexer error</a></li>
        <li class="error"><a href="?price]">Parser error</a></li>
    </ul>
</div>
