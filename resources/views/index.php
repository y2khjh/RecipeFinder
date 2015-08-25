<!DOCTYPE html>
<html>
<head>
    <title>Recipe Finder</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 38px;
        }

        div.section {
            border: 1px solid gray;
        }

        div.section .title {
            border-bottom: 1px solid gray;
            padding: 2px;
            background-color: gray;
            font-size: 18px;
        }

        div.section .body {
            padding: 2px;
        }

        div.table {
            display: table;
        }

        div.row  {
            display: table-row;
        }

        div.cell {
            display: table-cell;
            text-align: left;
            padding: 2px;
        }

        div.cell.item {
            width: 150px;
        }

        div.cell.amount, div.cell.unit, div.cell.use_by {
            width: 30px;
        }

        .json {
            width: 350px;
            height: 350px;
        }

        .red {
            background-color: #ff6666;
        }

        .green {
            background-color: #5cb85c;
        }

        .error, .recipe {
            font-size: 28px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">Recipe Finder</div><br/>
        <form action="<?php echo url('upload') ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="csvfile" />
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="submit" value="Upload CSV" name="upload_csvfile">
        </form><br/>
        <div class="section">
            <div class="title">Food in Fridge</div>
            <div class="table body">
                <?php foreach ($foodsInFridge as $food): ?>
                    <div class="row">
                        <div class="cell item"><?php echo $food->item ?></div>
                        <div class="cell amount"><?php echo $food->amount ?></div>
                        <div class="cell unit"><?php echo $food->unit ?></div>
                        <div class="cell use_by"><?php echo $food->use_by ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div><br/>
        <?php if (null !== $error = Session::get('error')): ?>
            <div class="section red">
                <div class="title">Error</div>
                <div class="body error"><?php echo $error ?></div>
            </div><br/>
        <?php endif; ?>
        <?php if (null !== $recipe_name = Session::get('recipe_name')): ?>
        <div class="section green">
            <div class="title">Recipe Found</div>
            <div class="body recipe"><?php echo $recipe_name ?></div>
            <input type="hidden" id="found_recipe" value="<?php echo $recipe_name ?>" />
        </div><br/>
        <?php endif; ?>
        <div class="section">
            <div class="title">Recipe JSON</div>
            <div class="body">
                <form action="<?php echo url('find_recipe') ?>" method="post">
                    <textarea class="json" name="json_data" placeholder="Copy and Paste the Json data to here"><?php echo isset($json) ? e($json) : e($defaultJson) ?></textarea><br/>
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="submit" value="Submit" name="submit_recipes">
                </form>
            </div>
        </div><br/>
    </div>
</div>
</body>
</html>
