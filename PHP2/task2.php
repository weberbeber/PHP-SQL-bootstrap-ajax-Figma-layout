<?php

/**
 * @charset UTF-8
 *
 * Задание 2. Работа с массивами и строками.
 *
 * Есть список временных интервалов (интервалы записаны в формате чч:мм-чч:мм).
 *
 * Необходимо написать две функции:
 *
 *
 * Первая функция должна проверять временной интервал на валидность
 * 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм)
 * 	возвращать boolean
 *
 *
 * Вторая функция должна проверять "наложение интервалов" при попытке добавить новый интервал в список существующих
 * 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм). Учесть переход времени на следующий день
 *  возвращать boolean
 *
 *  "наложение интервалов" - это когда в промежутке между началом и окончанием одного интервала,
 *   встречается начало, окончание или то и другое одновременно, другого интервала
 *
 *
 *
 *  пример:
 *
 *  есть интервалы
 *  	"10:00-14:00"
 *  	"16:00-20:00"
 *
 *  пытаемся добавить еще один интервал
 *  	"09:00-11:00" => произошло наложение
 *  	"11:00-13:00" => произошло наложение
 *  	"14:00-16:00" => наложения нет
 *  	"14:00-17:00" => произошло наложение
 */

# Можно использовать список:

$list = array (
	'09:00-11:00',
	'11:00-13:00',
	'15:00-16:00',
	'17:00-20:00',
	'20:30-21:30',
	'21:30-22:30',
);

/**
 * Проверка временного интервала на валидность
 * 
 * @param string $string
 * 
 * @return boolean
 * 
 */
function intervalValidation($interval)
{
	/*
	 * Проверка на соответствие шаблону: чч:мм-чч:мм
	 * чч - числа от 00 до 23
	 * мм - числа от 00 до 59
	 */
	return (boolean) preg_match('/^([0-1]\d|2[0-3]):([0-5]\d)-([0-1]\d|2[0-3]):([0-5]\d)$/', $interval);
}

/**
 * Разбиение интервала на 2 точки времени, начало и конец. 
 * Вспомогательная функция для intervalOverlay.
 * 
 * @param string $interval
 * 
 * @return int array
 * 
 */
function intervalSeparation($interval)
{
	// Любая дата для удобства дальнейшего вычисления
	$date = '12.05.2023 ';

	$intervalStart = strtotime($date . substr($interval, 0, 5));
	$intervalEnd = strtotime($date . substr($interval, 6, 5));

	// Обработка перехода времени на следующий день
	if ($intervalEnd < $intervalStart)
	{
		$intervalEnd += 86400;
	}

	return array ($intervalStart, $intervalEnd);
}

/**
 * Проверка наложения интервалов
 * 
 * @param string $string
 * 
 * @return boolean
 * 
 */
function intervalOverlay($interval)
{
	global $list;

	// Разделение интервала на начало и конец
	// [0] => начало интервала
	// [0] => конец интервала
	$interval = intervalSeparation($interval);

	foreach ($list as $value)
	{
		$listTime = intervalSeparation($value);

		if (($interval[0] < $listTime[1]) && ($interval[1] > $listTime[0]))
			return false;
	}

	return true;
}

echo intervalValidation('23:30-09:35') . '<br>';

echo intervalOverlay('23:30-09:35');
