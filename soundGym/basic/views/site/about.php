<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Welcome to the Hearing Test application! 
        <br>
        <li>Make sure to <a href="http://localhost:8080/index.php?r=site%2Flogin">Login</a> before you start!</li>
        <br>
        <li>After logging in successfully, go to the <a href="http://localhost:8080/index.php?r=site%2Findex">Home</a> Page and follow the instructions.</li>
        <br>
        <li>You can check your results over time in the <a href="http://localhost:8080/index.php?r=site%2Fresults">Results</a> Page.</li>
        <br>
        <br>
        If you have business inquiries or other questions, feel free to <a href="http://localhost:8080/index.php?r=site%2Fcontact">contact us</a>. Thank you. 
    </p>

    <!-- <code><?= __FILE__ ?></code> -->
</div>
