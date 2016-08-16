<?php

class ModelModuleSPSR extends Model
{
    public function install()
    {
        /**
         * @Table(name="spsr_cities")
         */
        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "spsr_cities` (".chr(13).chr(10);
        $sql .= "`spsr_city_id` INT(11) NOT NULL AUTO_INCREMENT,".chr(13).chr(10);
        $sql .= "`city_id` INT(11),".chr(13).chr(10);
        $sql .= "`city_owner_id` INT(11),".chr(13).chr(10);
        $sql .= "`city_name` VARCHAR(100),".chr(13).chr(10);
        $sql .= "`region_id` INT(11),".chr(13).chr(10);
        $sql .= "`region_owner_id` INT(11),".chr(13).chr(10);
        $sql .= "`region_name` VARCHAR(100),".chr(13).chr(10);
        $sql .= "`country_id` INT(11),".chr(13).chr(10);
        $sql .= "`coutnry_owner_id` INT(11),".chr(13).chr(10);
        $sql .= "`cod` INT(2),".chr(13).chr(10);
        $sql .= "PRIMARY KEY (`spsr_city_id`))".chr(13).chr(10);
        $sql .= "ENGINE=MyISAM";
        $this->db->query($sql);

        /**
         * @Table(name="spsr_offices")
         */
        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "spsr_offices` (".chr(13).chr(10);
        $sql .= "`spsr_office_id` INT(11) NOT NULL AUTO_INCREMENT,".chr(13).chr(10);
        $sql .= "`office_id` INT(11),".chr(13).chr(10);
        $sql .= "`office_owner_id` INT(11),".chr(13).chr(10);
        $sql .= "`city_name` VARCHAR(50),".chr(13).chr(10);
        $sql .= "`region` VARCHAR(100),".chr(13).chr(10);
        $sql .= "`address` VARCHAR(250),".chr(13).chr(10);
        $sql .= "`comment` VARCHAR(500),".chr(13).chr(10);
        $sql .= "`timezone_msk` VARCHAR(20),".chr(13).chr(10);
        $sql .= "`worktime` VARCHAR(50),".chr(13).chr(10);
        $sql .= "`email` VARCHAR(100),".chr(13).chr(10);
        $sql .= "`latitude` VARCHAR(50),".chr(13).chr(10);
        $sql .= "`longitude` VARCHAR(50),".chr(13).chr(10);
        $sql .= "`phone` VARCHAR(100),".chr(13).chr(10);
        $sql .= "PRIMARY KEY (`spsr_office_id`))".chr(13).chr(10);
        $sql .= "ENGINE=MyISAM";
        $this->db->query($sql);

        /**
         * @Table(name="spsr_order_status")
         */
        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "spsr_order_status` (".chr(13).chr(10);
        $sql .= "`spsr_order_status_id` INT(11) NOT NULL AUTO_INCREMENT,".chr(13).chr(10);
        $sql .= "`event_id` INT(11) NOT NULL,".chr(13).chr(10);
        $sql .= "`event_code` VARCHAR(45),".chr(13).chr(10);
        $sql .= "`delivery_id` INT(11) NOT NULL,".chr(13).chr(10);
        $sql .= "`name` VARCHAR(100),".chr(13).chr(10);
        $sql .= "PRIMARY KEY (`spsr_order_status_id`))".chr(13).chr(10);
        $sql .= "ENGINE=MyISAM";
        $this->db->query($sql);

        /**
         * @Table(name="spsr_rules")
         */
        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "spsr_rules` (".chr(13).chr(10);
        $sql .= "`spsr_rule_id` INT(11) NOT NULL AUTO_INCREMENT,".chr(13).chr(10);
        $sql .= "`order_status_id` INT(11) NOT NULL,".chr(13).chr(10);
        $sql .= "`notify` INT(1) DEFAULT 0,".chr(13).chr(10);
        $sql .= "`message` VARCHAR(255) DEFAULT NULL,".chr(13).chr(10);
        $sql .= "PRIMARY KEY (`spsr_rule_id`),".chr(13).chr(10);
        $sql .= "UNIQUE (`order_status_id`))".chr(13).chr(10);
        $sql .= "ENGINE=MyISAM";
        $this->db->query($sql);

        /**
         * @Table(name="spsr_tariff")
         */
        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "spsr_tariff` (".chr(13).chr(10);
        $sql .= "`spsr_tariff_id` INT(11) NOT NULL AUTO_INCREMENT,".chr(13).chr(10);
        $sql .= "`tariff` INT(3) NOT NULL,".chr(13).chr(10);
        $sql .= "`tariff_type` INT(3) NOT NULL,".chr(13).chr(10);
        $sql .= "`city_from` VARCHAR(100) NOT NULL,".chr(13).chr(10);
        $sql .= "`region_from` VARCHAR(150) NOT NULL,".chr(13).chr(10);
        $sql .= "`city_to` VARCHAR(100) NOT NULL,".chr(13).chr(10);
        $sql .= "`region_to` VARCHAR(150) NOT NULL,".chr(13).chr(10);
        $sql .= "`weight` DECIMAL(15,2) NOT NULL,".chr(13).chr(10);
        $sql .= "`price` DECIMAL(15,2) DEFAULT NULL,".chr(13).chr(10);
        $sql .= "`days` VARCHAR(10) DEFAULT NULL,".chr(13).chr(10);
        $sql .= "PRIMARY KEY (`spsr_tariff_id`))".chr(13).chr(10);
        $sql .= "ENGINE=MyISAM";
        $this->db->query($sql);

        /**
         * @Table(name="spsr_track")
         */
        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "spsr_track` (".chr(13).chr(10);
        $sql .= "`spsr_track_id` INT(11) NOT NULL,".chr(13).chr(10);
        $sql .= "`order_id` INT(11) NOT NULL,".chr(13).chr(10);
        $sql .= "`date_added` DATETIME DEFAULT NULL,".chr(13).chr(10);
        $sql .= "PRIMARY KEY (`spsr_track_id`))".chr(13).chr(10);
        $sql .= "ENGINE=MyISAM";
        $this->db->query($sql);

        /**
         * @Table(name="spsr_track_msg")
         */
        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "spsr_track_msg` (".chr(13).chr(10);
        $sql .= "`spsr_track_msg_id` INT(11) NOT NULL AUTO_INCREMENT,".chr(13).chr(10);
        $sql .= "`order_id` INT(11) DEFAULT NULL,".chr(13).chr(10);
        $sql .= "`spsr_track_id` INT(11) DEFAULT NULL,".chr(13).chr(10);
        $sql .= "`msg_code` VARCHAR(50) DEFAULT NULL,".chr(13).chr(10);
        $sql .= "`msg_info` VARCHAR(50) DEFAULT NULL,".chr(13).chr(10);
        $sql .= "`msg_text` VARCHAR(500) DEFAULT NULL,".chr(13).chr(10);
        $sql .= "`date_added` DATETIME DEFAULT NULL,".chr(13).chr(10);
        $sql .= "PRIMARY KEY (`spsr_track_msg_id`))".chr(13).chr(10);
        $sql .= "ENGINE=MyISAM";
        $this->db->query($sql);

        // Заполнение таблицы статусов СПСР
        $sql = "TRUNCATE TABLE `" . DB_PREFIX . "spsr_order_status`;";
        $sql .= "INSERT INTO `" . DB_PREFIX . "spsr_order_status` (`event_id`, `event_code`, `delivery_id`, `name`)".chr(13).chr(10);
        $sql .= "VALUES (1,'_CLCCH',NULL,'Отправление готово к вручению в офисе.'),".chr(13).chr(10);
        $sql .= "(2,'_CLCCS',NULL,'Оформлен самовывоз.'),".chr(13).chr(10);
        $sql .= "(3,'_CLCLB',NULL,'Отправление выдано курьеру для доставки.'),".chr(13).chr(10);
        $sql .= "(4,'_INGCL',NULL,'Согласована доставка.'),".chr(13).chr(10);
        $sql .= "(5,'_RIDLV',NULL,'Возвратное отправление доставлено отправителю.'),".chr(13).chr(10);
        $sql .= "(6,'IN3CC',NULL,'Изменена дата доставки на .'),".chr(13).chr(10);
        $sql .= "(7,'IN3CC',NULL,'Дата и время не согласованы при звонке получателю.'),".chr(13).chr(10);
        $sql .= "(8,'IN3CC',NULL,'Согласован самовывоз. Готово для самовывоза.'),".chr(13).chr(10);
        $sql .= "(9,'IN3CC',NULL,'Отказ от отправления при звонке получателю.'),".chr(13).chr(10);
        $sql .= "(10,'IN3CC',NULL,'Дата и время не согласованы при звонке получателю.'),".chr(13).chr(10);
        $sql .= "(11,'IN3CC',NULL,'Проблема по отправлению.'),".chr(13).chr(10);
        $sql .= "(12,'IN3CI',NULL,'Отправление прибыло в зону таможенного оформления.'),".chr(13).chr(10);
        $sql .= "(13,'IN3CO',NULL,'Отправление прошло таможенное оформление.'),".chr(13).chr(10);
        $sql .= "(14,'IN3DC',NULL,'Отправление выдано курьеру для доставки.'),".chr(13).chr(10);
        $sql .= "(15,'IN3DL',NULL,'Доставлено.'),".chr(13).chr(10);
        $sql .= "(16,'IN3DL',NULL,'Доставлено с повреждениями.'),".chr(13).chr(10);
        $sql .= "(17,'IN3DL',NULL,'Частичная доставка.'),".chr(13).chr(10);
        $sql .= "(18,'IN3ND',NULL,'Отправление не доставлено.'),".chr(13).chr(10);
        $sql .= "(19,'IN3ND',NULL,'Отправление не доставлено. Неправильный адрес.'),".chr(13).chr(10);
        $sql .= "(20,'IN3ND',NULL,'Отправление не доставлено. Офис получателя закрыт.'),".chr(13).chr(10);
        $sql .= "(21,'IN3ND',NULL,'Отправление не доставлено. Получатель переехал.'),".chr(13).chr(10);
        $sql .= "(22,'IN3ND',NULL,'Отправление не доставлено. Получателя нет дома/в офисе.'),".chr(13).chr(10);
        $sql .= "(23,'IN3ND',NULL,'Отправление не доставлено. Отказ от отправления.'),".chr(13).chr(10);
        $sql .= "(24,'IN3PE',NULL,'Проблема по отправлению.'),".chr(13).chr(10);
        $sql .= "(25,'IN3PL',NULL,'Посылка утеряна.'),".chr(13).chr(10);
        $sql .= "(26,'IN3RB',NULL,'Отправление прибыло в офис пункта назначения.'),".chr(13).chr(10);
        $sql .= "(27,'IN3RD',NULL,'Возврат доставлен отправителю.'),".chr(13).chr(10);
        $sql .= "(28,'IN3RE',NULL,'Оформлен возврат отправителю.'),".chr(13).chr(10);
        $sql .= "(29,'IN3SC',NULL,'Передано для доставки контрагенту.'),".chr(13).chr(10);
        $sql .= "(30,'IN3SI',NULL,'Отправление поступило на главный сортировочный центр.'),".chr(13).chr(10);
        $sql .= "(31,'INAPT',NULL,'Отправление находится в постамате.'),".chr(13).chr(10);
        $sql .= "(33,'INCHI',NULL,'Отправление прибыло в зону таможенной очистки.'),".chr(13).chr(10);
        $sql .= "(34,'INCHO',NULL,'Отправление передано в офис SPSR.'),".chr(13).chr(10);
        $sql .= "(35,'INDDA',NULL,'Согласована доставка.'),".chr(13).chr(10);
        $sql .= "(36,'INDEN',NULL,'Отказ получателя от отправления.'),".chr(13).chr(10);
        $sql .= "(37,'INDLV',NULL,'Отправление доставлено.'),".chr(13).chr(10);
        $sql .= "(38,'INRCE',NULL,'Срок хранения истёк.'),".chr(13).chr(10);
        $sql .= "(39,'INREL',NULL,'Отправление прошло таможенную очистку.'),".chr(13).chr(10);
        $sql .= "(40,'LDCRE',NULL,'Отправление в процессе доставки в постамат.'),".chr(13).chr(10);
        $sql .= "(41,'PM2PP',NULL,'Отправление покинуло офис SPSR.'),".chr(13).chr(10);
        $sql .= "(42,'PMAWH',NULL,'Отправление прибыло в экспортный транзитный терминал.'),".chr(13).chr(10);
        $sql .= "(43,'PMCLR',NULL,'Экпортное таможенное оформление завершено.'),".chr(13).chr(10);
        $sql .= "(44,'PMEMS',NULL,'Передано для доставки третьей стороне.'),".chr(13).chr(10);
        $sql .= "(45,'PMFDT',NULL,'Отправление выслано в Россию.'),".chr(13).chr(10);
        $sql .= "(46,'PMFSH',NULL,'Отправление забронировано на вылет.'),".chr(13).chr(10);
        $sql .= "(47,'PMLWH',NULL,'Отправление проходит экспортное таможенное оформление.'),".chr(13).chr(10);
        $sql .= "(48,'PMPDU',NULL,'Отправление покинуло склад отправителя.'),".chr(13).chr(10);
        $sql .= "(49,'PMRDC',NULL,'Отправление прибыло в офис SPSR пункта назначения.'),".chr(13).chr(10);
        $sql .= "(50,'PMWGT',NULL,'Отправление поступило в офис SPSR.'),".chr(13).chr(10);
        $sql .= "(51,'PPOPN',NULL,'Отправление готово к доставке.'),".chr(13).chr(10);
        $sql .= "(52,'RICRE',NULL,'Оформлен возврат отправления.'),".chr(13).chr(10);
        $sql .= "(53,'ININF',NULL,'Изменен адрес доставки.'),".chr(13).chr(10);
        $sql .= "(54,'IN2MN',NULL,'Получена информация об отправлении.'),".chr(13).chr(10);
        $sql .= "(55,'INDLV',50,'Отправление доставлено.'),".chr(13).chr(10);
        $sql .= "(56,'INDLV',51,'Отправление доставлено.'),".chr(13).chr(10);
        $sql .= "(57,'INDLV',53,'Отправление доставлено.'),".chr(13).chr(10);
        $sql .= "(58,'INDLV',54,'Отправление доставлено.'),".chr(13).chr(10);
        $sql .= "(59,'INDLV',55,'Отправление доставлено.'),".chr(13).chr(10);
        $sql .= "(60,'INDLV',56,'Отправление доставлено.'),".chr(13).chr(10);
        $sql .= "(61,'INDLV',59,'Отправление доставлено.'),".chr(13).chr(10);
        $sql .= "(62,'INDLV',60,'Отправление доставлено. Неполное количество мест многоместного отправления'),".chr(13).chr(10);
        $sql .= "(92,'INDLV',111,'Отправление доставлено.'),".chr(13).chr(10);
        $sql .= "(93,'INDLV',112,'Отправление доставлено.'),".chr(13).chr(10);
        $sql .= "(100,'INDLV',120,'Отправление доставлено. Доставлена часть товара в отправлении'),".chr(13).chr(10);
        $sql .= "(105,'_PLPST',NULL,'Планируемая отправка.'),".chr(13).chr(10);
        $sql .= "(106,'_PPOUT1',NULL,'Отправление покинуло офис SPSR.'),".chr(13).chr(10);
        $sql .= "(107,'_CLCTR1',NULL,'Отправление прибыло в транзитный пункт.'),".chr(13).chr(10);
        $sql .= "(108,'_PPOUT2',NULL,'Отправление покинуло транзитный пункт.'),".chr(13).chr(10);
        $sql .= "(109,'_CLCTR2',NULL,'Отправление готово к доставке.'),".chr(13).chr(10);
        $sql .= "(110,'_CLCSV',NULL,'Оформлен самовывоз.'),".chr(13).chr(10);
        $sql .= "(111,'_CLCDD',NULL,'Согласована доставка.'),".chr(13).chr(10);
        $sql .= "(112,'_CLCDR',NULL,'Отправление доставлено.'),".chr(13).chr(10);
        $sql .= "(113,'_CLCRI',NULL,'Оформлен возврат отправления.'),".chr(13).chr(10);
        $sql .= "(114,'_CLCRD',NULL,'Возвратное отправление доставлено отправителю.'),".chr(13).chr(10);
        $sql .= "(115,'MBDON',NULL,'Денежные средства переведены на счет клиента.'),".chr(13).chr(10);
        $sql .= "(116,'INDSS',NULL,'Отправление доставлено.'),".chr(13).chr(10);
        $sql .= "(117,'INLST',NULL,'Отправление утрачено.'),".chr(13).chr(10);
        $sql .= "(119,'INGCA',NULL,'Изменение адреса доставки .'),".chr(13).chr(10);
        $sql .= "(120,'INATC',NULL,'Ожидание согласования даты и времени.'),".chr(13).chr(10);
        $sql .= "(122,'PM2LD',NULL,'Отправление выдано курьеру для доставки.'),".chr(13).chr(10);
        $sql .= "(123,'INACR',NULL,'Ожидание согласования даты и времени.'),".chr(13).chr(10);
        $sql .= "(124,'INACR',NULL,'Прозвон получателя: Проблема - контактный телефон не принадлежит получателю.'),".chr(13).chr(10);
        $sql .= "(125,'INACR',NULL,'Ожидание согласования даты и времени.'),".chr(13).chr(10);
        $sql .= "(126,'INACR',NULL,'Прозвон получателя: Неудачная попытка связаться с получателем.'),".chr(13).chr(10);
        $sql .= "(127,'INACR',NULL,'Прозвон получателя: Не доступен/выключен/заблокирован.'),".chr(13).chr(10);
        $sql .= "(128,'INACR',NULL,'Прозвон получателя: Не отвечает на телефонный звонок.'),".chr(13).chr(10);
        $sql .= "(129,'INACR',NULL,'Прозвон получателя: Неудачная попытка связаться с получателем.'),".chr(13).chr(10);
        $sql .= "(130,'INACR',NULL,'Прозвон получателя: Проблема - телефонный номер не существует.'),".chr(13).chr(10);
        $sql .= "(131,'INACR',NULL,'Прозвон получателя: Занято.'),".chr(13).chr(10);
        $sql .= "(132,'INACR',NULL,'Прозвон получателя: Проблема - направлен запрос отправителю.'),".chr(13).chr(10);
        $sql .= "(133,'INRCR',NULL,'Отказ от отправления. Качество, брак товара.'),".chr(13).chr(10);
        $sql .= "(134,'INRCR',NULL,'Отказ от отправления. Не подошёл товар.'),".chr(13).chr(10);
        $sql .= "(135,'INRCR',NULL,'Отказ от отправления. Неполная комплектация заказа.'),".chr(13).chr(10);
        $sql .= "(136,'INRCR',NULL,'Отказ от отправления. Нет необходимости в заказе.'),".chr(13).chr(10);
        $sql .= "(137,'INRCR',NULL,'Отказ от отправления. Не устраивают условия доставки.'),".chr(13).chr(10);
        $sql .= "(138,'INRCR',NULL,'Отказ от отправления. Долгое ожидание заказа.'),".chr(13).chr(10);
        $sql .= "(139,'INRCR',NULL,'Отказ от отправления. Не доступны дополнительные сервисы.'),".chr(13).chr(10);
        $sql .= "(140,'INRCR',NULL,'Отказ от отправления. Нечем оплатить заказ.'),".chr(13).chr(10);
        $sql .= "(141,'INRCR',NULL,'Отказ от отправления. По запросу отправителя.'),".chr(13).chr(10);
        $sql .= "(142,'INRCR',NULL,'Отказ от отправления. Ошибочное оформление заказа.'),".chr(13).chr(10);
        $sql .= "(32,'INBAD',NULL,'Отправление не доставлено. Отправление не доставлено'),".chr(13).chr(10);
        $sql .= "(63,'INBAD',62,'Отправление не доставлено. Отправление не доставлено'),".chr(13).chr(10);
        $sql .= "(64,'INBAD',63,'Отправление не доставлено. Отправление не доставлено'),".chr(13).chr(10);
        $sql .= "(65,'INBAD',64,'Отправление не доставлено. По адресу получатель не найден'),".chr(13).chr(10);
        $sql .= "(66,'INBAD',65,'Отправление не доставлено. Отправление не доставлено'),".chr(13).chr(10);
        $sql .= "(67,'INBAD',67,'Отправление не доставлено. Отправление не доставлено'),".chr(13).chr(10);
        $sql .= "(68,'INBAD',68,'Отправление не доставлено. Доставка без созвона невозможна'),".chr(13).chr(10);
        $sql .= "(69,'INBAD',69,'Отправление не доставлено. Доставка без указания ФИО получателя невозможна'),".chr(13).chr(10);
        $sql .= "(70,'INBAD',70,'Отправление не доставлено. Юридический адрес'),".chr(13).chr(10);
        $sql .= "(71,'INBAD',74,'Отправление не доставлено. Закрыто в стандартное рабочее время'),".chr(13).chr(10);
        $sql .= "(72,'INBAD',75,'Отправление не доставлено. Отправление не доставлено'),".chr(13).chr(10);
        $sql .= "(73,'INBAD',83,'Отправление не доставлено. Отправление не доставлено'),".chr(13).chr(10);
        $sql .= "(74,'INBAD',84,'Отправление не доставлено. По инициативе получателя изменена дата доставки'),".chr(13).chr(10);
        $sql .= "(75,'INBAD',85,'Отправление не доставлено. По инициативе получателя изменен адрес доставки'),".chr(13).chr(10);
        $sql .= "(76,'INBAD',86,'Отправление не доставлено. Получатель заберет отправление самостоятельно в офисе СПСР'),".chr(13).chr(10);
        $sql .= "(77,'INBAD',87,'Отправление не доставлено. Получатель отказался заполнить ЛИП'),".chr(13).chr(10);
        $sql .= "(78,'INBAD',88,'Отправление не доставлено. Отправление не доставлено'),".chr(13).chr(10);
        $sql .= "(79,'INBAD',89,'Отправление не доставлено. Отправление не доставлено'),".chr(13).chr(10);
        $sql .= "(80,'INBAD',90,'Отправление не доставлено. Вход в здание получателя невозможен'),".chr(13).chr(10);
        $sql .= "(81,'INBAD',92,'Отправление не доставлено. Отправление не доставлено'),".chr(13).chr(10);
        $sql .= "(82,'INBAD',93,'Отправление не доставлено. Получатель не может подтвердить свою личность'),".chr(13).chr(10);
        $sql .= "(83,'INBAD',94,'Отправление не доставлено. Получатель не готов к оплате'),".chr(13).chr(10);
        $sql .= "(84,'INBAD',95,'Отправление не доставлено. Отправление не доставлено'),".chr(13).chr(10);
        $sql .= "(85,'INBAD',96,'Отправление не доставлено. Отправление не доставлено'),".chr(13).chr(10);
        $sql .= "(86,'INBAD',98,'Отправление не доставлено. Отправление не доставлено'),".chr(13).chr(10);
        $sql .= "(87,'INBAD',102,'Отправление не доставлено. Отказ от отправления (неполное содержимое)'),".chr(13).chr(10);
        $sql .= "(88,'INBAD',103,'Отправление не доставлено. Отказ от отправления'),".chr(13).chr(10);
        $sql .= "(89,'INBAD',105,'Отправление не доставлено. Отказ от отправления (не требуется)'),".chr(13).chr(10);
        $sql .= "(90,'INBAD',107,'Отправление не доставлено. Отказ от отправления'),".chr(13).chr(10);
        $sql .= "(91,'INBAD',109,'Отправление не доставлено. Отказ от отправления (бракованный товар)'),".chr(13).chr(10);
        $sql .= "(94,'INBAD',114,'Отправление не доставлено. Отказ от отправления (не подошел товар)'),".chr(13).chr(10);
        $sql .= "(95,'INBAD',115,'Отправление не доставлено. Не готовы возвратные документы'),".chr(13).chr(10);
        $sql .= "(96,'INBAD',116,'Отправление не доставлено. Отправление не доставлено'),".chr(13).chr(10);
        $sql .= "(97,'INBAD',117,'Отправление не доставлено. Расходятся данные в документах и паспорте'),".chr(13).chr(10);
        $sql .= "(98,'INBAD',118,'Отправление не доставлено. Отсутствие документов'),".chr(13).chr(10);
        $sql .= "(99,'INBAD',119,'Отправление не доставлено. Неидентичная подпись получателя'),".chr(13).chr(10);
        $sql .= "(101,'INBAD',121,'Отправление не доставлено. В постамате нет места'),".chr(13).chr(10);
        $sql .= "(102,'INBAD',122,'Отправление не доставлено. Не поместилось в постамат'),".chr(13).chr(10);
        $sql .= "(103,'INBAD',123,'Отправление не доставлено. Постамат не работает'),".chr(13).chr(10);
        $sql .= "(104,'INBAD',125,'Отправление не доставлено. Отказ получателя от фото/подписания документов'),".chr(13).chr(10);
        $sql .= "(143,'INBAD',127,'Отправление не доставлено. Получателя нет дома'),".chr(13).chr(10);
        $sql .= "(144,'INBAD',128,'Отправление не доставлено. Получателя нет в офисе'),".chr(13).chr(10);
        $sql .= "(145,'INBAD',130,'Отправление не доставлено. По запросу отправителя'),".chr(13).chr(10);
        $sql .= "(146,'INBAD',134,'Отправление не доставлено. Неправильный адрес'),".chr(13).chr(10);
        $sql .= "(147,'INBAD',129,'Отправление не доставлено. Сотрудник получателя не работает в компании'),".chr(13).chr(10);
        $sql .= "(149,'INBAD',60,'Отправление не доставлено. Неполное количество мест многоместного отправления'),".chr(13).chr(10);
        $sql .= "(150,'INBAD',120,'Отправление не доставлено. Доставлена часть товара в отправлении'),".chr(13).chr(10);
        $sql .= "(175,'INJNK',NULL,'Отправление утилизировано.')";
        $this->db->query($sql);
    }

    public function getUploadData($orders)
    {
        $data = array();

        foreach ($orders as $order_id) {
            $sql = "SELECT o.order_id, o.total, o.shipping_firstname, o.shipping_lastname, o.shipping_postcode, o,shipping_country_id, o.shipping_country, o.shipping_zone_id, o.shipping_zone, o.shipping_city, CONCAT(' ', o.shipping_address_1, o.shipping_address_2) AS 'shipping_address', o.telephone, o.comment, o.email".chr(13).chr(10);
            $sql .= "FROM `" . DB_PREFIX . "order` o".chr(13).chr(10);
            $sql .= "WHERE o.order_id = '" . (int)$order_id . "'";

            $result = $this->db->query($sql);
            $order_info = $result->row;
            $paid = $this->checkPaid($order_id);
            $product_type = $this->config->get('spsr_intgr_product_type');

            $sql = "SELECT op.order_product_id, op.name, op.price, op.quantity".chr(13).chr(10);
            $sql .= "FROM `" . DB_PREFIX . "order_product` op".chr(13).chr(10);
            $sql .= "WHERE op.order_id = '" . (int)$order_id . "'";
            $result = $this->db->query($sql);
            $products = $result->rows;

            $quantity = 0;
            $p_zero = 0;
            foreach ($products as $product) {
                $quantity += $product['quantity'];
                if ($product['price'] == 0) {
                    $p_zero += $product['quantity'];
                }
            }
            $q_paid = $quantity - $p_zero;

            $sql = "SELECT p.product_id, op.quantity, p.weight, pov.weight_prefix, pov.weight AS 'opt_weight'".chr(13).chr(10);
            $sql .= "FROM `" . DB_PREFIX . "order_product` op".chr(13).chr(10);
            $sql .= "INNER JOIN `" . DB_PREFIX . "product` p ON op.product_id = p.product_id".chr(13).chr(10);
            $sql .= "INNER JOIN `" . DB_PREFIX . "order_option` oo ON op.order_product_id = oo.order_product_id".chr(13).chr(10);
            $sql .= "INNER JOIN `" . DB_PREFIX . "product_option_value` pov ON oo.product_option_value_id = pov.product_option_value_id".chr(13).chr(10);
            $sql .= "WHERE op.order_id = '" . (int)$order_id . "' AND pov.option_id = 6".chr(13).chr(10);
            $sql .= "GROUP BY p.product_id, op.quantity, p.weight, pov.weight_prefix, pov.weight";
            $result = $this->db->query($sql);
            $weight = 0;

            foreach ($result->rows as $p) {
                if ($p['weight_prefix'] == '+') {
                    $weight += (float)$p['quantity'] * ((float)$p['weight'] + (float)$p['opt_weight']);
                } else {
                    $weight += (float)$p['quantity'] * ((float)$p['weight'] - (float)$p['opt_weight']);
                }
            }

            $totals = $this->getDiscounts($order_id);
            $u_products = array();
            foreach ($products as $product) {
                $price = $product['price'];
                if ((int)$product['price'] > 0) {
                    if ((float)$totals['discount'] > 0 || (float)$totals['coupon'] > 0) {
                        $price = $product['price'] - (float)$totals['discount']/$q_paid - (float)$totals['coupon']/$q_paid;
                    }
                }

                $price = number_format($price, 2, '.', '');

                $u_products[] = array(
                    'order_product_id' => $product['order_product_id'],
                    'name' => $product['name'],
                    'option' => $this->getProductOptions($product['order_product_id']),
                    'quantity' => $product['quantity'],
                    'price' => $price
                );
            }

            $data[] = array(
                'order_id' => $order_info['order_id'],
                'paid' => $paid,
                'total' => $totals['total'],
                'weight' => $weight,
                'shipping_customer' => $order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname'],
                'shipping_postcode' => $order_info['shipping_postcode'],
                'shipping_country_id' => $order_info['shipping_country_id'],
                'shipping_country' => $order_info['shipping_country'],
                'shipping_zone_id' => $order_info['shipping_zone_id'],
                'shipping_zone' => $order_info['shipping_zone'],
                'shipping_city' => $order_info['shipping_city'],
                'shipping_address' => $order_info['shipping_address'],
                'telephone' => $order_info['telephone'],
                'comment' => $order_info['comment'],
                'email' => $order_info['email'],
                'products_type' => $product_type,
                'shipping_cost' => $totals['shipping_cost'],
                'discount' => $totals['discount'],
                'coupon' => $totals['coupon'],
                'total_quantity' => $quantity,
                'products' => $u_products
            );
        }

        return $data;
    }

    public function getUploadDataByStatusId($order_status_id) {
        $sql = "SELECT o.order_id".chr(13).chr(10);
        $sql .= "FROM `" . DB_PREFIX . "order` o".chr(13).chr(10);
        $sql .= "WHERE o.order_status_id = '" . (int)$order_status_id . "'";
        $result = $this->db->query($sql);
        $rows = $result->rows;

        $data = array();
        foreach ($rows as $row) {
            $data[] = $row['order_id'];
        }

        $orders = $this->getUploadData($data);

        return $orders;
    }

    public function saveTrackNumbers($data) {
        foreach ($data as $track) {
            if ((int)$track['spsr_track_id'] > 0) {
                $sql = "INSERT INTO `" . DB_PREFIX . "spsr_track` SET order_id = '" . (int)$track['order_id'] . "', spsr_track_id = '" . (int)$track['spsr_track_id'] . "', date_added = NOW();";
                $this->db->query($sql);
            }

            if (count($track['msg']) > 0) {
                foreach ($track['msg'] as $msg) {
                    $sql = "INSERT INTO `" . DB_PREFIX . "spsr_track_msg` SET `order_id` = '" . (int)$track['order_id'] . "', `spsr_track_id` = '" . (int)$track['spsr_track_id'] . "', `msg_code` = '" . $this->db->escape($msg['code']) . "', `msg_info`='" . $this->db->escape($msg['info']) . "', `msg_text` = '" . $this->db->escape($msg['text']) . "', date_added = NOW();";
                    $this->db->query($sql);
                }
            }
        }
    }

    public function getSpsrStatuses() {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "spsr_order_status`");
        return $query->rows;
    }

    private function checkPaid($order_id) {
        if (empty($this->config->get('spsr_intgr_paid_order_status'))) {
            $order_status_id = $this->config->get('spsr_intgr_paid_order_status');
        } else {
            $order_status_id = 9;
        }

        // 9 - статус оплаченного заказа
        $result = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_history` oh WHERE oh.order_id = '" . (int)$order_id . "' AND oh.order_status_id = '" . $order_status_id . "'");
        if ($result->num_rows > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    private function getDiscounts($order_id) {
        $sql = "SELECT ot.value AS 'shipping_cost'".chr(13).chr(10);
        $sql .= "FROM `" . DB_PREFIX . "order_total` ot".chr(13).chr(10);
        $sql .= "WHERE ot.order_id = '" . (int)$order_id . "' AND ot.code ='shipping'";
        $result = $this->db->query($sql);
        $shipping_cost = $result->row['shipping_cost'];

        $sql = "SELECT ot.value AS 'total'".chr(13).chr(10);
        $sql .= "FROM `" . DB_PREFIX . "order_total` ot".chr(13).chr(10);
        $sql .= "WHERE ot.order_id = '" . (int)$order_id . "' AND ot.code ='total'";
        $result = $this->db->query($sql);
        $total = $result->row['total'];

        $sql = "SELECT ot.value AS 'discount'".chr(13).chr(10);
        $sql .= "FROM `" . DB_PREFIX . "order_total` ot".chr(13).chr(10);
        $sql .= "WHERE ot.order_id = '" . (int)$order_id . "' AND ot.code ='discount_tasty'";
        $result = $this->db->query($sql);
        if ($result->num_rows > 0) {
            $discount = abs($result->row['discount']);
        } else {
            $discount = 0;
        }

        $sql = "SELECT ot.value AS 'coupon'".chr(13).chr(10);
        $sql .= "FROM `" . DB_PREFIX . "order_total` ot".chr(13).chr(10);
        $sql .= "WHERE ot.order_id = '" . (int)$order_id . "' AND ot.code ='coupon'";
        $result = $this->db->query($sql);
        if ($result->num_rows > 0) {
            $coupon = abs($result->row['coupon']);
        } else {
            $coupon = 0;
        }

        unset($result);

        $result = array(
            'shipping_cost' => number_format($shipping_cost,2,'.',''),
            'total' => number_format($total,2,'.',''),
            'discount' => number_format($discount,2,'.',''),
            'coupon' => number_format($coupon,2,'.','')
        );

        return $result;
    }

    private function getProductOptions($product_id) {

        $sql = "SELECT oo.order_product_id, oo.name, oo.value".chr(13).chr(10);
        $sql .= "FROM `" . DB_PREFIX . "order_option` oo".chr(13).chr(10);
        $sql .= "WHERE oo.order_product_id = '" . (int)$product_id . "'";
        $query = $this->db->query($sql);

        $opt_name = '';
        foreach ($query->rows as $option) {
            $opt_name .= '- '.$option['name'].': '.$option['value'].chr(13).chr(10);
        }

        return $opt_name;

    }
}

?>