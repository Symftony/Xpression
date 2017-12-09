<div class="head">
    <div class="container">
        <a href="index.php">Basic</a>
        <a href="querystring.php">Query string</a>
        <a href="constraint.php">Disable operator</a>
        <a href="closure.php">Closure filter</a>
        <a href="collection.php">Doctrine ArrayCollection filter</a>
        <a href="orm.php">Doctrine ORM</a>
        <a href="mongodb.php">Doctrine MongoDb</a>
    </div>
</div>
<style>
    body {
        margin: 0;
    }

    code {
        display: inherit;
    }

    .head {
        padding-top: 20px;
        border-bottom: 1px solid rgb(225, 228, 232);
        background-color: rgb(250, 251, 252);
    }

    .head a {
        text-decoration: none;
        color: #000000;
        display: inline-block;
        padding: 10px;
        border-top: 1px solid rgb(225, 228, 232);
        border-left: 1px solid rgb(225, 228, 232);
        border-right: 1px solid rgb(225, 228, 232);
        background-color: #ffffff;
        border-radius: 5px 5px 0 0;
    }

    .container {
        margin-left: auto;
        margin-right: auto;
        width: 980px;
    }

    .content {
        border: 1px solid rgb(207, 216, 230);
        padding: 0 20px;
    }

    .content:first-of-type {
        border-radius: 5px 5px 0 0;
    }

    .content:last-of-type {
        border-radius: 0 0 5px 5px;
        margin-bottom: 10px;
    }

    .content > * {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .code {
        border: 1px solid rgb(43, 43, 43);
        background-color: rgb(0, 0, 0);
        color: #bababa;
    }

    .info {
        border: 1px solid rgb(207, 216, 230);
        background-color: rgb(237, 243, 250);
    }

    .important {
        border: 1px solid #faf7a5;
        background-color: #faf8b9;
    }

    .warning {
        border: 1px solid #ffb566;
        background-color: #ffcf99;
    }

    .error {
        border: 1px solid #ffb3b3;
        background-color: #ffcccc;
    }

    form {
        border: 1px solid #bebebe;
        padding: 10px;
        margin-bottom: 0;
    }

    div.exception > div.exception {
        margin-left: 20px;
    }

    .debug {
        background-color: #ffffff;
        border: 1px dashed #e48706;
        padding: 10px;
    }

    .debug .important,
    .debug .warning,
    .debug .error {
        border-radius: 5px;
        padding: 1px 6px;
    }

    table.data {
        width: 100%;
        border-collapse: collapse;
    }

    table.example {
        width: 100%;
        text-align: center;
    }

    table.example a {
        text-decoration: none;
        background-color: rgb(237, 243, 250);
        border-radius: 3px;
        padding: 0 5px;
    }

    table.data th {
        border-top: 1px solid grey;
    }

    table.data th, table.data td {
        border-bottom: 1px solid grey;
    }

    fieldset {
        border: 1px dotted #1b6d85;
        border-radius: 5px;
    }

    .query {
        font-size: 40px;
    }

    fieldset legend {
        background-color: #d1f1f5;
        border-radius: 5px;
    }

    ul.example {
        overflow: hidden;
        list-style: none;
        padding: 0;
    }

    ul.example li {
        float: left;
        background-color: #dedede;
        border-radius: 5px;
        margin: 2px 5px;
        padding: 3px;
    }

    ul.example a {
        color: #000000;
        text-decoration: none;
    }
</style>
