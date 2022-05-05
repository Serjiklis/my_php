<?php
function print_ar($arr)
{
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

interface DeliveryType
{
	public function getDeliveryName();
}


class Novaposhta implements DeliveryType
{
	const DELIVERY_NAME = 'Новая Почта';

	public function getDeliveryName()
	{
		return self::DELIVERY_NAME;
	}
}


class Ukrposhta implements DeliveryType
{
	const DELIVERY_NAME = 'Укрпочта';

	public function getDeliveryName()
	{
		return self::DELIVERY_NAME;
	}
}


interface PaymentType
{
	public function getPaymentName();
}


class Liqpay implements PaymentType
{
	const PAYMENT_NAME = 'LiqPay';

	public function getPaymentName()
	{
		return self::PAYMENT_NAME;
	}
}


class Monobank implements PaymentType
{
	const PAYMENT_NAME = 'MonoPay';

	public function getPaymentName()
	{
		return self::PAYMENT_NAME;
	}
}

class User
{
	private string $name;
	private string $surname;

	public function __construct($name, $surname)
	{
		$this->name = $name;
		$this->surname = $surname;
	}

	public function getUserName()
	{
		$userName = $this->name.' '.$this->surname;
		return $userName;
	}
}

class Product
{
	public int $goodsID;
	public string $goodsName;
	public int $quantity;
	// public float $price;
	/**
	 * [__construct формирует данные для добавленияв корзину]
	 * @param [integer]  $goodsID   [ID уникальный номер товара]
	 * @param [string]  $goodsName [Название товара]
	 * @param integer $quantity  [Количество товара, по умолчанию добавляется 1]
	 */
	public function __construct($goodsID, $goodsName, $quantity = 1)
	{
		$this->goodsID = $goodsID;
		$this->goodsName = $goodsName;
		$this->quantity = $quantity;
	}
}

class Cart
{
	private $userFullName;

	private $products = [];

	private $goods = [];

	public function __construct($user)
	{
		$this->userFullName = $user;
	}
	/**
	 * [addProduct - добавление товаров в корзину]
	 * @param [array] $product [содержит товар который добавляется в корзину]
	 */
	public function addProduct($product)
	{
		$product = (array)$product;

		if(array_key_exists($product['goodsID'], $this->products))
		{
			$this->products[$product['goodsID']]['quantity'] = $this->products[$product['goodsID']]['quantity'] + $product['quantity'];
		}else
		{
			$this->products[$product['goodsID']] = $product;
		}
	}
	/**
	 * [delProduct - удаление товаров из корзины]
	 * @param  integer  $goodsID  [Указывается ID товара который необходимо удалить]
	 * @param  integer $quantity [Количество товаров для удаления, по умолчанию 1]
	 * @return [array]            [Возвращает массив с товарами после удаления]
	 */
	public function delProduct($goodsID, $quantity=1)
	{
		if(array_key_exists($goodsID, $this->products))
		{
			if ($this->products[$goodsID]['quantity'] > $quantity )
			{
				$this->products[$goodsID]['quantity'] = $this->products[$goodsID]['quantity'] - $quantity;

				return $this->products;
			}
			if ($this->products[$goodsID]['quantity'] <= $quantity )
			{
				unset($this->products[$goodsID]);

				return $this->products;
			}
		}
	}


	public function getProduct()
	{
		return $this->products;
	}

	public function getUser()
	{
		return $this->userFullName;
	}
}



class Order
{
	private $user;
	private $goods;
	private $payment;
	private $delivery;

	public function __construct($user, $goods, $payment = 2, $delivery = 1)
	{
		$this->user = $user;
		$this->goods = $goods;
		$this->payment = $payment;
		$this->delivery = $delivery;
	}

	public function make()
	{
		echo 'Получатель: ' . $this->user . '<br>';

		foreach ($this->goods as $key => $value) {
			print_ar('Название: ' . $value['goodsName']. ' / ' .'Количество: '. $value['quantity']);
		}
		echo 'Платежная система: ';
		echo ($this->payment == 1) ? Monobank::PAYMENT_NAME : Liqpay::PAYMENT_NAME .  '<br>';
		echo '<br>';
		echo 'Служба доставки: ';
		echo ($this->delivery == 1) ? Ukrposhta::DELIVERY_NAME : Novaposhta::DELIVERY_NAME . '<br>';
		echo '<br>';
	}
}

$user = new User('Anton', 'Cibulya');
$userName = $user->getUserName();

//Товары
$dog = new Product(10, 'Grifon');
$cat = new Product(12, 'Cat');
$bird = new Product(14, 'Bird');

//Корзина
$cart = new Cart($userName);

//Объект пользователя для передачи в Ордер
$user = $cart->getUser();

//Добавляем товары в корзину
$cart->addProduct($dog);
$cart->addProduct($dog);
$cart->addProduct($cat);
$cart->addProduct($bird);
$cart->addProduct($bird);
$cart->addProduct($bird);
$cart->addProduct($cat);
$cart->addProduct($cat);
$cart->addProduct($cat);
$cart->addProduct($cat);

//Выводим товары на экран
print_ar($cart->getProduct());

//Удаляем часть товаров
$cart->delProduct(12);
$cart->delProduct(12);
$cart->delProduct(14);
$cart->delProduct(10);

//Выывод на экран после удаления
print_ar($cart->getProduct());

//формируем данные для оформления заказа
$goods = $cart->getProduct();

//создаем заказ
$order = new Order($user, $goods);

//Вывод данных по заказу на экран
$order->make();
