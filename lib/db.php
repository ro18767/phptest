<h1>Робота з базами даних</h1>
<h2>СУБД. Налаштування</h2>
<p>
	При роботі з БД бажано мати змогу створити нову БД та нового
	користувача для неї. Якщо такої змоги немає, то принаймні 
	реалізувати окрему схему або окремий префікс.
</p>
<p>
	Розглянемо ці процеси на прикладі локального сервера MySQL/MariaDB
	(постачається у збірці XAMPP). Для нього немає принципових обмежень
	за правами доступу, тому є можливість створювати БД та користувачів.
</p>
<p>
	Підключаємось до СУБД: На панелі XAMPP обираємо Shell<br/>
	Переходимо до папки з MySQL:<br/>
	<code>cd mysql/bin</code><br/>
	Запускаємо клієнт (консоль БД, сервер БД має бути запущений з 
	панелі керування ХАМРР)<br/>
	<code>mysql -u root</code><br/>
	У результаті успіху з'явиться вітання БД та промпт "MariaDB [(none)]>"<br/>
	Створюємо БД<br/>
	<code>CREATE DATABASE pv111;</code><br/>
	Створюємо користувача, надаємо йому права на дану БД<br/>
	<code>GRANT ALL PRIVILEGES ON pv111.* TO 'pv111_user'@'localhost' IDENTIFIED BY 'pv111_pass';</code><br/>
	Зберігаємо змінені привілеї<br/>
	<code>FLUSH PRIVILEGES;</code><br/>
	Перевіряємо, виходимо з консолі<br/>
	<code>EXIT</code><br/>
	І пробуємо зайти з новими обліковими даними, на запит паролю вводимо pv111_pass<br/>
	<code>mysql -u pv111_user -p</code><br/>
	Якщо бачимо вітання, значить перевірка успішна
</p>
<h2>Підключення РНР</h2>
<p>
	У РНР існує декілька способів роботи з БД: профільні (mysqli_, ib_, ...)
	та універсальний підхід PDO. Цей підхід вимагає підключення модуля РНР та
	драйверів БД. У XAMPP налаштовані mysql, sqlite (перевірити можна
	через phpinfo(), секція PDO)
</p>
<p>
	Підключення здійснюється створенням нового об'єкту PDO із передачею
	у конструктор даних автентифікації.<br/>
	<em>$db = new PDO("mysql:host=localhost;dbname=pv111;charset=UTF8", "pv111_user", "pv111_pass");</em>
	<br/>
	Встановлюємо атрибути роботи з БД<br/>
	Режим вибірки (за індексом, за назвою чи за обома) - за назвою<br/>
	<em>$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC) ;</em>
	<br/>
	Режим помилок (повернення true/false або викид виключення)<br/>
	<em>$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;</em>
	<br/>
	Дозвіл на утримання підключення (повторні підключення будуть 
	намагатись спочатку використаті старі)<br/>
	<em>$db->setAttribute(PDO::ATTR_PERSISTENT, true) ;</em>
</p>
<?php

// виконання запиту
try {
    $res = $db->query("SELECT CURRENT_TIMESTAMP UNION SELECT CURRENT_DATE UNION SELECT 1");
    ?>
    <div class="row">
        <div class="col s12 m7">
            <div class="card">
                <div class="card-content">
                    <table>
                        <thead>
                            <tr>
                                <th>CURRENT_TIMESTAMP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?= $res->fetch(PDO::FETCH_COLUMN) ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?= $res->fetch(PDO::FETCH_COLUMN) ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?= $res->fetch(PDO::FETCH_COLUMN) ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <?php

} catch (PDOException $ex) {
    echo $ex->getMessage();
}



// https://www.ietf.org/rfc/rfc2898.txt
$sql = <<<SQL
CREATE TABLE IF NOT EXISTS users (
    `id`        BIGINT          PRIMARY KEY,
    `login`     VARCHAR(64)     NOT NULL,
    `salt`      CHAR(16)        NOT NULL,
    `pass_dk`   CHAR(40)        NOT NULL,
    `name`      VARCHAR(64)     NULL,
    `email`     VARCHAR(64)     NULL,
    `avatar`    VARCHAR(512)    NULL

) ENGINE = InnoDB DEFAULT CHARSET = utf8
SQL;

try {
    $db->query($sql);
    echo 'CREATE OK';
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
?>