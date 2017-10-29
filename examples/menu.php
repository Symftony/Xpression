<div class="head">
    <div class="container">
        <a href="basic.php">Basic</a>
        <a href="collection.php">Collection filter</a>
    </div>
</div>
<style>
    .container {
        margin-left: auto;
        margin-right: auto;
        width: 980px;
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

    .content {
        margin-top: 20px;
        border: 1px solid rgb(207, 216, 230);
        border-radius: 5px;
        background-color: rgb(237, 243, 250);
        padding: 0 20px;
    }

    .content > * {
        margin-top: 20px;
        margin-bottom: 20px;
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
    div.exception>div.exception {
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
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th {
        border-top: 1px solid grey;
    }
    th, td {
        border-bottom: 1px solid grey;
    }
</style>
