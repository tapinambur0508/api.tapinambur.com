<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
$tapinamburAPI=new tapinamburAPI();
$title='tapinambur API | Головна';
$style_less=array("system-style.less");
include_once($_SERVER['DOCUMENT_ROOT'].'/app/header.php');
?>
<div id="myContainer">
<h1>Що таке tapinambur API?</h1>
<p>tapinambur API - це великий "Супермаркет новин", який допоможе наповнювати Ваш сайт якісним та свіжим контентом.</p>
<h2>Синтаксис</h2>
<p>
Щоб отримати список новин у форматі JSON, потрібно зробити запит у вигляді:<br/>
<mark>http://api.tapinambur.com/api/count=&lt;кількість новин&gt;</mark>,<br/>
де&nbsp;<strong>count</strong> - кількість новин, яку Ви хочете отримати.
</p>
<p>
Також, якщо Ви хочете отримати список певних новин у форматі JSON, потрібно зробити запит у вигляді:<br/>
<mark>http://api.tapinambur.com/api/news-key=&lt;ключ для обраних новин&gt;</mark>,<br/>
де&nbsp;<strong>news-key</strong> - ключ для отримання певних новин. Генерується після обрання Вами певних новин в кошику.
</p>
<h2>Основні положення</h2>
<p>
Кожного дня наш "Супермаркет новин" поповнюється більш ніж на 100 нових цікавих новин IT, автомобільних новин і т.і. В нашому "Супермаркеті новин" кожна новина містить посилання на її джерело, тож ми не порушуємо авторські права на статтю. Розмітка має формат HTML, яку легко можна вставити на Ваш сайт. Кількість запитів, яку можна провести в день, є необмеженою.
</p>
<h2>JSON</h2>
<p>Після запиту Ви отримуєте відповідь у форматі JSON. Відповідь містить два ключі: <strong>code</strong> - статус запиту, <strong>response</strong> - асоціативний масив статті.</p>
<h2>Значення парметра code</h2>
<table class="table-bordered">
<thead>
<tr>
<th>Значення</th>
<th>Опис</th>
</tr>
</thead>
<tbody>
<tr>
<td>200</td>
<td>Запит пройшов успішно</td>
</tr>
<tr>
<td>401</td>
<td>Параметр count не валідний</td>
</tr>
<tr>
<td>402</td>
<td>Параметр news-key не валідний</td>
</tr>
<tr>
<td>403</td>
<td>За вашим параметром news-key не знайдено новин</td>
</tr>
</tbody>
</table>
<h2>Ключі парметра response</h2>
<table class="table-bordered">
<thead>
<tr>
<th>Ключ</th>
<th>Значення</th>
</tr>
</thead>
<tbody>
<tr>
<td>header</td>
<td>Заголовок статті</td>
</tr>
<tr>
<td>content</td>
<td>Короткий зміст статті. Описує її загальний зміст. В деяких статтях може бути відсутнім</td>
</tr>
<tr>
<td>full_content</td>
<td>Повний зміст сторінки. Містить текст, зображення, відео. Має формат HTML</td>
</tr>
<tr>
<td>image</td>
<td>Мале зображення для статті</td>
</tr>
<tr>
<td>cover_image</td>
<td>Велике зображення для статті</td>
</tr>
<tr>
<td>source</td>
<td>Джерело</td>
</tr>
<tr>
<td>key_word</td>
<td>Ключові слова</td>
</tr>
</tbody>
</table>
</div>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/app/footer.php'); ?>
