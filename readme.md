Для корректной работы в файлах index.php прописать следующее

// SPSR
require_once(DIR_SYSTEM . 'library/spsr/spsr.php');
$registry->set('spsr', new spsr($registry));

// TODO
вывод информации об адресе ПВЗ и Постамата в админке и в личном кабинете
выгрузка заказов до ПВЗ и Постаматов