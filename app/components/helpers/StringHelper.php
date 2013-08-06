<?php

/**
 * Вспомогательные функции для работы со строками
 */
class StringHelper
{
    private static $_symbols = array(
        ',' => '_',
        '.' => '_',
        ' ' => '_',
        '!' => '',
        '?' => '',
        '%' => '',
        '#' => '',
        '$' => '',
        '*' => '',
        '(' => '_',
        ')' => '_',
        '+' => '_',
        '=' => '_',
        ':' => '',
        ';' => '_',
    );

    private static $_cyr = array(
        "Щ", "Ш", "Ч", "Ц", "Ю", "Я", "Ж", "А", "Б", "В", "Г", "Д", "Е", "Ё", "З", "И", "Й", "К", "Л", "М", "Н", "О", "П", "Р",
        "С", "Т", "У", "Ф", "Х", "Ь", "Ы", "Ъ", "Э", "Є", "Ї",
        "щ", "ш", "ч", "ц", "ю", "я", "ж", "а", "б", "в", "г", "д", "е", "ё", "з", "и", "й", "к", "л", "м", "н", "о", "п", "р",
        "с", "т", "у", "ф", "х", "ь", "ы", "ъ", "э", "є", "ї", " ", "_",
    );

    private static $_lat = array(
        "Shh", "Sh", "Ch", "C", "Ju", "Ja", "Zh", "A", "B", "V", "G", "D", "Je", "Jo", "Z", "I", "J", "K", "L", "M", "N", "O", "P",
        "R", "S", "T", "U", "F", "Kh", "", "Y", "", "E", "Je", "Ji",
        "shh", "sh", "ch", "c", "ju", "ja", "zh", "a", "b", "v", "g", "d", "e", "jo", "z", "i", "j", "k", "l", "m", "n", "o", "p",
        "r", "s", "t", "u", "f", "kh", "", "y", "", "e", "e", "ji", "-", "-"
    );

    /**
     * Создает урл из названия
     *
     * @param string $string
     * @return string
     */
    public static function createSlug($string)
    {
        $string = trim($string);
        $string = str_replace(array_keys(self::$_symbols), array_values(self::$_symbols), $string);

        $slug = strtolower(str_replace(self::$_cyr, self::$_lat, $string));
        return trim(preg_replace('/\-+/', '-', $slug), '-');
    }


    /**
     * Удаляет кавычки из строки
     *
     * @static
     * @param string $string
     * @return string
     */
    public static function stripQuotes($string)
    {
        return str_replace(array('"', '\''), '', $string);
    }

    /**
     * Обрезка текста
     *
     * @static
     * @param string $text
     * @param int    $count
     * @return string
     */
    public static function truncate($text, $count = 10)
    {
        $len  = mb_strlen($text, 'UTF-8');
        $text = mb_substr($text, 0, $count, 'UTF-8');

        if ($len > $count) {
            $text .= ' ...';
        }

        return $text;
    }
}
