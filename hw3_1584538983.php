<?php

// Задание: написать валидацию "формы" добавления книги на сайт,
// используя функции и декларативный подход 
// В качестве данных формы использовать ассоциативный массив со СТРОКОВЫМИ значениями
// Пункты со звездочкой * выполнять не обязательно. Если не получится самостоятельно, мы в любом случае реализуем их вместе на занятии.
    require_once('validation.php');
/**
 * Данные формы 
 * "Пользовательский ввод". Меняйте эти значение для тестирования вашей реализации. 
 */
$form = [
  "title" => "   Война   и  мир",
  "author" => "Лев   толстой ", 
  "year" => "1991",
  "isbn" => "0-8044-2957-X",
  "isAvailable" => "1",
];


/**
 * Схема валидации
 * ! Можно менять формат, в соответсвии с вашей релизацей. 
 * Главное, чтобы проверка и отчиска выполнялись в соответсвии со спецификацией и схема была легко настраивамой
 */
$validationScheme = [
  
  /**
   * 1. Название книги (string)
   *    а  обрезать лишние пробелы слева и справа
   *    б  проверить что поле не пустое => Добавить ошибку "Обязательное поле"
   *    в преобразовать все последовательности пробелов в один пробел: Например "Война      и  мир" => "Война и мир"
   */
  "title" => [
    "clear-extra-spaces", 
    "require"
  ],

  /**
   * 2. Автор (string)
   *    а  обрезать лишние пробелы слева и справа
   *    б  проверить что поле не пусое => Добавить ошибку "Обязательное поле"
   *    в преобразовать все последовательности пробелов в один пробел: Например "Лев   Толстой" => "Лев Толстой"
   *    г* убедиться, что имена написаны с большой буквы: "лев толстой" => "Лев Толстой"
   */
  "author" =>  [
    "clear-extra-spaces", 
    "require", 
    function ($v) {
        return [mb_convert_case($v, MB_CASE_TITLE),null];
        // Реализация пункта Г.
    }
  ],

  /**
   * 3. Год (int)
   *    а  обрезать лишние пробелы слева и справа
   *    б  поле не обязательное, поэтому следующие проверки делать только если есть значение
   *    в  проверить, что значение - целое число => Добавить ошибку "Год должен быть числом"
   *    г  преобразовать в число integer
   *    д  проверить, что год находится в промежутке от 1500 до 2020 => Добавить ошибку "Недопустимый год" 
   */
  "year" => [
    "clear-extra-spaces",
    "integer",
    generateRangeValidator(1500, 2020) // ! Один из вариантов решения
  ],


  /**
   * 4. ISBN - муждународный код книги (string)
   * Это десятизначиный код, состоящий из 4 груп переменной длины разделенных дефисом. 
   * Первые три группы состоят только из цифр. Послденяя - один символ: цифра или X
   * Примеры: 0-8044-2957-X или 85-359-0277-5
   *    a  обрезать лишние пробелы слева и справа
   *    б  поле не обязательное, поэтому следующие проверки делать только если есть значение
   *    в  убрать лишние пробелы из середины строки, если имеются
   *    г  проверить, что код состоит ровно из 4 групп разделенных дефисом => Добавить ошибку "Неверный ISBN"
   *    д  проверить, что первые три групп состоят только из цифр => Добавить ошибку "Неверный ISBN"
   *    е  проверить, что последняя группа - это одна цифра или X => Добавить ошибку "Неверный ISBN"
   *    ж* заменить три вышеперечисленные проверки одним регулярным выражением => Добавить ошибку "Неверный ISBN"
   */
  "isbn" => [
    "clear-extra-spaces",
    generateLengthValidator(10, 10), // ! Один из вариантов решения
    generateRegExpValidator("/Регулярное выражение для проверки ISBN/")
  ],

  /**
   * 5. Доступна ли книга (bool)
   *    а  преобразовать в тип bool. Пустая строка - false, любая другая - true
   */
  "isAvailable" => [
    "bool"
  ]

];


// Вызов функции валидации формы.
[$clean, $errors] = validateForm($validationScheme, $form);


// !!! Вынести следующий код в отдельный файл и подключить его в этот
// validation.php



/**
 * Функция проверяет и нормализует входные данные формы
 * в соотвествии с указанной схемой валидации
 * 
 * !! Функция должна принимать аргументы и возвращать значения в том формате что указа здесь
 * 
 * Если будете реализовывать возможность последовательных валидаторов, не забудьте, 
 * во-первых, что возникновение ошибки в одном из валидаторов должно останавливать проверку текущего поля
 * во-вторых, очищенные значения должны передаваться по цепочке
 * 
 * @param mixed[] $scheme схема валидации 
 * @param string[] $form данные формы 
 * @return array[] Возврвщвет массив нормальизованных данных и массив ошибок
 */
function validateForm($scheme, $form) {

  // > Ваша реализация
  
  return [$clean, $errors];
}


// Функции валидации и вспомогательные функции 
// !! Можно менять в соответсвии с вашей идеей архитектуры

// require
// clearExtraSpaces
// integer
// bool


/**
 * Генерирует функцию, котрая проверяет, что число находится в промежутке
 * @param int $min нижняя граница
 * @param int $max верхняя граница
 * @return callable функция-валидатор 
 */
function generateRangeValidator($min = 0, $max = PHP_INT_MAX) {
  return function($value) use ($min, $max) {
    return [$clean, $error];
  };
}


/**
 * Генерирует функцию, котрая проверяет, что длина строки находится в промежутке
 * @param int $min нижняя граница
 * @param int $max верхняя граница
 * @return callable функция-валидатор 
 */
function generateLengthValidator($min = 0, $max = PHP_INT_MAX) {
  return function($value) use ($min, $max) {
    return [$clean, $error];
  };
}

/**
 * Генерирует функцию, котрая проверяет, что значение соответсвует регулярному выражению
 * @param int $regexp регулярное выражение для проверки
 * @return callable функция-валидатор 
 */
function generateRegExpValidator($regexp) {
  return function($value) use ($regexp) {
    return [$clean, $error];
  };
}


// Конец validation.php



// Результат валидации и нормализации ввода.
// ! Этот код менять не нужно. Он выводи результат в наглядном виде

$viewModel = [
  [
    "Название",
    "title",
  ],
  [
    "Автор",
    "author",
  ],
  [
    "Год издания",
    "year",
  ],
  [
    "ISBN",
    "isbn",
  ],
  [
    "Доступно",
    "isAvailable",
  ]
];
?>


<html>
<head>
<style>

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  table {
    margin: 24px auto;
    border-spacing: 1px 4px;
    font: 16px sans-serif;
    width: 800px;
  }

  td {
    padding: 10px 6px;
  }

  .invalid td {
    background-color: hsl(10, 70%, 90%);
  }

  .valid td {
    background-color: hsl(120, 70%, 90%);
  }

  .name {
    width: 14%;
  }

  .value, .clean {
    width: 23%;
  }

  .error {
    width: 40%;
  }

</style>
</head>
<body>
<table>

  <tr>
    <td class="name">&nbsp;</td>
    <td class="value">Значение на входе</td>
    <td class="clean">Нормализованное</td>
    <td class="error">Ошибка</td>
  </tr>
  
  <?php foreach ($viewModel as [$name, $key]) {?>

  <tr class="<?=@$errors[$key] ? "invalid" : "valid"?>">
    <td class="name"><?=$name?></td>
    <td class="value"><pre><?=var_export(@$form[$key], true)?><pre></td>
    <td class="clean"><pre><?=var_export(@$clean[$key], true)?><pre></td>
    <td class="error"><?=@$errors[$key]?></td>
  </tr>
  
  <?}?>
</table>
</body>
</html>




