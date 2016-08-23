<?php

class ModelShippingSPSR extends Model
{
    public function install()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "spsr_tariff` (".chr(13).chr(10);
        $sql .= "`spsr_tariff_id` INT(11) NOT NULL AUTO_INCREMENT,".chr(13).chr(10);
        $sql .= "`tariff` VARCHAR(10) NOT NULL,".chr(13).chr(10);
        $sql .= "`tariff_type` INT(3) NOT NULL,".chr(13).chr(10);
        $sql .= "`city_from` VARCHAR(100) NOT NULL,".chr(13).chr(10);
        $sql .= "`region_from` VARCHAR(150) NOT NULL,".chr(13).chr(10);
        $sql .= "`city_to` VARCHAR(100) NOT NULL,".chr(13).chr(10);
        $sql .= "`region_to` VARCHAR(150) NOT NULL,".chr(13).chr(10);
        $sql .= "`weight` DECIMAL(15,2) NULL,".chr(13).chr(10);
        $sql .= "`price` DECIMAL(15,2) NULL,".chr(13).chr(10);
        $sql .= "`days` VARCHAR(10) NULL,".chr(13).chr(10);
        $sql .= "PRIMARY KEY (`spsr_tariff_id`))".chr(13).chr(10);
        $sql .= "ENGINE=MyISAM;";
        $this->db->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "spsr_tariff_type` (".chr(13).chr(10);
        $sql .= "`spsr_tariff_type_id` INT(11) NOT NULL AUTO_INCREMENT,".chr(13).chr(10);
        $sql .= "`tariff_code` VARCHAR(10) NOT NULL,".chr(13).chr(10);
        $sql .= "`tariff_name` VARCHAR(50) NOT NULL,".chr(13).chr(10);
        $sql .= "PRIMARY KEY (`spsr_tariff_type_id`))".chr(13).chr(10);
        $sql .= "ENGINE=MyISAM";
        $this->db->query($sql);

        $sql = "TRUNCATE TABLE `" . DB_PREFIX . "spsr_tariff_type`";
        $this->db->query($sql);

        $sql = "INSERT INTO `" . DB_PREFIX . "spsr_tariff_type` (`tariff_code`, `tariff_name`) VALUES".chr(13).chr(10);
        $sql .= "('Dox', 'Колибри-документ'),".chr(13).chr(10);
        $sql .= "('Gep13', 'Гепард-Экспресс 13'),".chr(13).chr(10);
        $sql .= "('Gep18', 'Гепард-Экспресс 18'),".chr(13).chr(10);
        $sql .= "('GepEx', 'Гепард-Экспресс'),".chr(13).chr(10);
        $sql .= "('PelSt', 'Пеликан-Стандарт'),".chr(13).chr(10);
        $sql .= "('PelEc', 'Пеликан-Эконом'),".chr(13).chr(10);
        $sql .= "('BisCa', 'Бизон-Карго'),".chr(13).chr(10);
        $sql .= "('BisAv', 'Бизон-Авиа'),".chr(13).chr(10);
        $sql .= "('Freig', 'Фрахт'),".chr(13).chr(10);
        $sql .= "('PelOn', 'Пеликан-Онлайн'),".chr(13).chr(10);
        $sql .= "('GepOn', 'Гепард-Онлайн'),".chr(13).chr(10);
        $sql .= "('ZebOn', 'Зебра-Онлайн'),".chr(13).chr(10);
        $sql .= "('PelInt', 'Pelican International'),".chr(13).chr(10);
        $sql .= "('GepInt', 'Guepard-International')";
        $this->db->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "spsr_postamat_order` (".chr(13).chr(10);
        $sql .= "`spsr_postamat_order_id` INT(11) NOT NULL AUTO_INCREMENT,".chr(13).chr(10);
        $sql .= "`order_id` INT(11) NOT NULL,".chr(13).chr(10);
        $sql .= "`postamat_id` VARCHAR(20) NOT NULL,".chr(13).chr(10);
        $sql .= "`postamat_name` VARCHAR(100) NOT NULL,".chr(13).chr(10);
        $sql .= "`postamat_address` VARCHAR(150) NOT NULL,".chr(13).chr(10);
        $sql .= "PRIMARY KEY (`spsr_postamat_order_id`))".chr(13).chr(10);
        $sql .= "ENGINE=MyISAM";
        $this->db->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "spsr_pvz_order` (".chr(13).chr(10);
        $sql .= "`spsr_pvz_order_id` INT(11) NOT NULL AUTO_INCREMENT,".chr(13).chr(10);
        $sql .= "`order_id` INT(11) NOT NULL,".chr(13).chr(10);
        $sql .= "`spsr_office_id` INT(11) NOT NULL,".chr(13).chr(10);
        $sql .= "PRIMARY KEY (`spsr_pvz_order_id`))".chr(13).chr(10);
        $sql .= "ENGINE=MyISAM";
        $this->db->query($sql);

        unset($sql);
    }

    public function getSpsrCities($data)
    {
        $sql = "SELECT * FROM `" . DB_PREFIX . "spsr_cities`";
        if (isset($data['filter_name'])) {
            $sql .= " WHERE `city_name` LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
        }
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getSpsrCityByName($name)
    {
        $city = preg_replace('/^\s*г\.?\s+/isu', '', $name);
        $sql = "SELECT * FROM `" . DB_PREFIX . "spsr_cities` WHERE `city_name` = '" . $this->db->escape($city) . "'";
        $query = $this->db->query($sql);
        return $query->row;
    }

    public function addTariff($data)
    {
        //$tariff = implode(',', $data);
        $sql = "INSERT INTO `" . DB_PREFIX . "spsr_tariff` (tariff, tariff_type, city_from, region_from, city_to, region_to, `weight`, `price`, `days`) VALUES ";
        $sql .= '(' . implode('),(', $data) . ')';
        $this->db->query($sql);
    }

    public function delAllTariff()
    {
        $this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "spsr_tariff`");
    }
}

?>