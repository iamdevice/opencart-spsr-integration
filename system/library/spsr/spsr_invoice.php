<?php

class spsr_invoice implements invoice
{
    private $icn;
    private $number;
    private $order_id;
    private $pickup_type;
    private $product_code;
    private $description;
    private $insurance_sum;
    private $declared_sum;
    private $cod_products_sum;
    private $cod_delivery_sum;
    private $courier_number;
    private $status;
    private $delivery_date;
    private $agreed_date;
    private $shipper = array();
    private $receiver = array();
    private $sms_shipper_telephone;
    private $sms_receiver_telephone;
    private $products = array();

    public function getData()
    {
        $data = array(
            'icn' => $this->icn,
            'number' => $this->number,
            'order_id' => $this->order_id,
            'pickup_type' => $this->pickup_type,
            'product_code' => $this->product_code,
            'description' => $this->description,
            'insurance_sum' => $this->insurance_sum,
            'declared_sum' => $this->declared_sum,
            'cod_products_sum' => $this->cod_products_sum,
            'cod_delivery_sum' => $this->cod_delivery_sum,
            'courier_number' => $this->courier_number,
            'status' => $this->status,
            'delivery_date' => $this->delivery_date,
            'agreed_date' => $this->agreed_date,
            'shipper' => $this->shipper,
            'receiver' => $this->receiver,
            'sms_shipper_telephone' => $this->sms_shipper_telephone,
            'sms_receiver_telephone' => $this->sms_receiver_telephone,
            'products' => $this->products
        );

        return $data;
    }

    public function setData($data)
    {
        $this->icn = (string)$data['ContractNumber'];
        $this->number = (string)$data['ShipmentNumber'];
        $this->order_id = (string)$data['ShipRefNum'];
        $this->pickup_type = (string)$data['PickUpType'];
        $this->product_code = (string)$data['ProductCode'];
        $this->description = (string)$data['FullDescription'];
        $this->insurance_sum = (string)$data['InsuranceSum'];
        $this->declared_sum = (string)$data['DeclaredSum'];
        $this->cod_products_sum = (string)$data['CODGoodsSum'];
        $this->cod_delivery_sum = (string)$data['CODDeliverySum'];
        $this->courier_number = (string)$data['OrderNumber'];
        $this->status = (string)$data['CurState'];
        $this->delivery_date = (string)$data['DeliveryDT'];
        $this->agreed_date = (string)$data['AgreedDate'];
        $this->shipper = array(
            'postcode' => (string)$data->Shipper['PostCode'],
            'country' => (string)$data->Shipper['Country'],
            'region' => (string)$data->Shipper['Region'],
            'city' => (string)$data->Shipper['City'],
            'address' => (string)$data->Shipper['Address'],
            'company' => (string)$data->Shipper['CompanyName'],
            'contact' => (string)$data->Shipper['ContactName'],
            'telephone' => (string)$data->Shipper['Phone']
        );
        $this->receiver = array(
            'postcode' => (string)$data->Receiver['PostCode'],
            'country' => (string)$data->Receiver['Country'],
            'region' => (string)$data->Receiver['Region'],
            'city' => (string)$data->Receiver['City'],
            'address' => (string)$data->Receiver['Address'],
            'company' => (string)$data->Receiver['CompanyName'],
            'contact' => (string)$data->Receiver['ContactName'],
            'telephone' => (string)$data->Receiver['Phone'],
            'comment' => (string)$data->Receiver['Comment'],
            'pvz' => (string)$data->Receiver['ConsigneeCollect']
        );
        $this->sms_shipper_telephone = (string)$data->SMS['SMSNumberShipper'];
        $this->sms_receiver_telephone = (string)$data->SMS['SMSNumberReceiver'];

        $products = array();
        foreach ($data->Pieces->Piece as $product) {
            $products[] = array(
                'product_id' => (string)$product['PieceID'],
                'description' => (string)$product['Description'],
                'weight' => (string)$product['Weight'],
                'length' => (string)$product['Length'],
                'width' => (string)$product['Width'],
                'depth' => (string)$product['Depth'],
                'client_weight' => (string)$product['ClientWeight'],
                'qty' => (string)$product['Quantity']
            );
        }
        $this->products = $products;
    }

    public function checkStatus($status)
    {
        //$status = mb_strtolower($status, 'UTF-8');
        if (mb_stripos($status, "Обработка") !== false) {
            return 1;
        } elseif (mb_stripos($status, "Не доставлено") !== false) {
            return 3;
        } else {
            return 2;
        }
    }
}

?>