Для корректной работы в файлах index.php прописать следующее

// SPSR
require_once(DIR_SYSTEM . 'library/spsr/interface/invoice.php');
require_once(DIR_SYSTEM . 'library/spsr/spsr.php');
require_once(DIR_SYSTEM . 'library/spsr/spsr_invoice.php');
$registry->set('spsr', new spsr($registry));

// TODO
вывод информации об адресе ПВЗ и Постамата в админке и в личном кабинете
проверка типа тарифа по последнему символу в коде (например, проверять не spsr.zebon2, а просто 2 для тарифа до ПВЗ)
переделать функцию sendXML под AJAX
расширеный мониторинг доставки (сейчас отслеживается только по WAGetInvoiceInfo/1.1)
при отсутствии данных о тарифе - получать данные с серверов SPSR