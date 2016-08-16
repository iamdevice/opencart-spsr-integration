Для корректной работы в файлах index.php прописать следующее

// SPSR
require_once(DIR_SYSTEM . 'library/spsr/spsr.php');
$registry->set('spsr', new spsr($registry));