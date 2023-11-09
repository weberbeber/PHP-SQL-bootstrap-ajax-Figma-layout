<?php

/**
 * @charset UTF-8
 *
 * Задание 2
 * В данный момент компания X работает с двумя перевозчиками
 * 1. Почта России
 * 2. DHL
 * У каждого перевозчика своя формула расчета стоимости доставки посылки
 * Почта России до 10 кг берет 100 руб, все что cвыше 10 кг берет 1000 руб
 * DHL за каждый 1 кг берет 100 руб
 * Задача:
 * Необходимо описать архитектуру на php из методов или классов для работы с
 * перевозчиками на предмет получения стоимости доставки по каждому из указанных
 * перевозчиков, согласно данным формулам.
 * При разработке нужно учесть, что количество перевозчиков со временем может
 * возрасти. И делать расчет для новых перевозчиков будут уже другие программисты.
 * Поэтому необходимо построить архитектуру так, чтобы максимально минимизировать
 * ошибки программиста, который будет в дальнейшем делать расчет для нового
 * перевозчика, а также того, кто будет пользоваться данным архитектурным решением.
 *
 */

# Использовать данные:
# любые

abstract class Transporter
{
    /**
     * Метод для расчёта стоимости перевозки
     * @param int $kg - вес груза
     * @return mixed - стоимость перевозки
     */
    public abstract function calculateCost(int $kg): int;
}

class RussianPost extends Transporter
{
    public function calculateCost($kg): int
    {
        if ($kg <= 10) return 100;
        else return 1000;
    }
}

class DHL extends Transporter
{
    public function calculateCost(int $kg): int
    {
        return $kg * 100;
    }
}

class TransporterProvider
{
    public array $transporters;

    public function __construct(...$transporters)
    {
        foreach ($transporters as $t)
            $this->transporters[] = $t;
    }

    /**
     * Добавляет перевозчика в список перевозчиков
     * @param Transporter $transporter - перевозчик
     */
    public function addTransporter(Transporter $transporter)
    {
        $this->transporters[] = $transporter;
    }

    /**
     * Выводит стоимости доставки всех добавленных перевозчиков
     * @param int $kg - вес перевозимого груза
     */
    public function checkCostOfTransporting(int $kg)
    {
        foreach ($this->transporters as $t)
            echo $t->calculateCost($kg)."\n";
    }
}

/* Пример */
$tp = new TransporterProvider(new RussianPost());

$tp->addTransporter(new DHL());

$tp->checkCostOfTransporting(5);

/**
 * Для добавления нового перевозчика неоюходимо его определить, унаследовавшись от Transporter,
 * переопределив метод calculateCost, после чего добавив его в через метод класса
 * TransporterProvider::addTransporter()
 *
 * Для получения списка стоимостей вызывается метод TransporterProvider::checkCostOfTransporting()
 */