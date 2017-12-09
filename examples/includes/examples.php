<div class="content">
    <ul class="example">
        <li><a href="?query={constructor='Lexus'}">constructor = 'Lexus'</a></li>
        <li><a href="?query={price=13}">price = 13</a></li>
        <li><a href="?query={price≠5}">price ≠ 5</a></li>
        <li><a href="?query={price>5}">price > 5</a></li>
        <li><a href="?query={price≥5}">price ≥ 5</a></li>
        <li><a href="?query={price<5}">price < 5</a></li>
        <li><a href="?query={price≤5}">price ≤ 5</a></li>
        <li><a href="?query={price>5&price<14}">price > 5 & price < 14</a></li>
        <li><a href="?query={price>5&price<14|constructor='Lexus'}">price > 5 & price < 14 | constructor = 'Lexus'</a></li>
        <li><a href="?query={year[1990,1996,2006]}">year [1990,1996,2006]</a></li>
        <li><a href="?query={model{{Disco}}}">model {{Disco}}</a></li>
        <li><a href="?query={model!{{Disco}}}">model !{{Disco}}</a></li>
        <li><a href="?query={constructor='Lexus'&price≥4|price≤17}">constructor = 'Lexus' & price ≥ 4 | price ≤ 17</a></li>
        <li><a href="?query={constructor='Lexus'&(price≥4|price≤17)}">constructor = 'Lexus' & (price ≥ 4 | price ≤ 17)</a></li>
        <li class="error"><a href="?query={pr$ice}">Lexer error</a></li>
        <li class="error"><a href="?query={price]}">Parser error</a></li>
    </ul>
</div>
