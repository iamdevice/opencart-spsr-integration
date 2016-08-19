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