<?php

$arSquare = [];
try {
    $arSquare = makeSquare(999);
} catch (Exception $e) {
    echo $e->getMessage();
}

?>

<?php if($arSquare): ?>

    <table>
        <?php foreach ($arSquare as $items): ?>
        <tr>
            <?php foreach ($items as $row): ?>
            <td><?php echo $row; ?></td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </table>

<?php endif;?>

<?php
/**
 * @throws Exception
 */
function makeSquare(int $inputValue): array {

    if($inputValue < 3) {
        throw new \RuntimeException('Введите нечетное число больше 1.');
    }
    if($inputValue % 2 === 0) {
        throw new \RuntimeException("Введите нечетное число. Число $inputValue является четным.");
    }

    $arSquare = [];

    // значение для незакрашенных елементов
    $spaceValue = 0;
    // значение для закрашенных елементов
    $fillValue = $inputValue;
    // центр
    $center = (int)floor($inputValue / 2);

    // статическая переменная каличества закрашиваемых елементов
    static $countFill = 1;

    // создаю незакрашенный массив для дальнейшего перекрашивания
    static $arPainted;
    $arPainted = array_fill(0, $inputValue, $spaceValue);

    // в цикле перенаполняю незакрашенный массив закрашенным определяя количество и индексы заменяемых елементов
    for($i = 0; ($i < $inputValue); $i++) {

        // если не достигли середины и не первая итерация, то на увеличение.
        if($i !== 0 && $i < $center) {
            $countFill += 2;
        }

        // если середина, то закрашиваем всё
        if($i === $center) {
            $countFill = $inputValue;
        }

        // если прошили середину, то на убавление
        if($i > $center) {
            $countFill -= 2;
        }

        // индекс начала закрашивания
        $startIndex = $center - (int) floor($countFill / 2);

        // создаю массив с закрашиваемыми ключами и значениями
        $arFill = array_fill($startIndex, $countFill, $fillValue);

        // закрашиваю массив в цикле
        // если еще не прошли середину
        if($i <= $center) {
            foreach($arFill as $fillKey => $fillVal) {
                if(array_key_exists($fillKey, $arPainted)) {
                    $arPainted[$fillKey] = $fillVal;
                }
            }
        }else{
            foreach($arPainted as $paintKey => $paintVal) {
                if(!array_key_exists($paintKey, $arFill)) {
                    $arPainted[$paintKey] = $spaceValue;
                }
            }
        }
        $arSquare[] = $arPainted;
    }

    return $arSquare;
}

?>
