<?
class Xml_prom
{
	private $offer_id;
	private $availible;
	private $price;
	private $param = array();
	private $url;
	private $currencyId;
	private $categoryId;
	private $picture = array();
	private $name;
	private $vendor;
	private $vendorCode;
	private $description;
	private $rate;
	
	public function __construct($rate, $offer_id, $availible, $price, $param, $url, $currencyId, $categoryId, $picture, $name, $vendor, $vendorCode, $description)
	{
		$this->rate = $rate;
		$this->offer_id = $offer_id;
        $this->availible = $availible;
		$this->price = $price;
		$this->param = $param;
		$this->url = $url;
		$this->currencyId = $currencyId;
		$this->categoryId = $categoryId;
		$this->picture = $picture;
		$this->name = $name;
		$this->vendor = $vendor;
		$this->vendorCode = $vendorCode;
		$this->description = $description;
	}
	
	public function Ready_Item()
        {
			
$pattern = "/(\&nbsp)/U";
$replacement = "";
$this->description=preg_replace($pattern, $replacement, $this->description);
$price = round($this->price * $this->rate);
$item = '<offer id="'.$this->offer_id.'" available="'.$this->availible.'">
<url><![CDATA['.$this->url.']]></url>
<price>'.$price.'</price>
<stock_quantity>100</stock_quantity>
<currencyId>'.$this->currencyId.'</currencyId>
<categoryId>'.$this->categoryId.'</categoryId>
';

foreach ($this->picture as $picture1)
{
$item = $item.$picture1;
}   
$item = $item.'<name>'.$this->name.'</name>
<vendor>'.$this->vendor.'</vendor>
<vendorCode>'.$this->vendorCode.'</vendorCode>
<description>'.$this->description.'</description>
';
if (!empty($this->param)):
foreach ($this->param as $param1)
{
	$item = $item.$param1;
}            
//kiarent2000@gmail.com
	else:
endif;	
	$item = $item.'</offer>
';			
			return $item;
        }
	
}
class Xml_prom_category
{
	private $category_id;
	private $parent_id;
	private $category_name;
	
	public function __construct($category_id, $parent_id, $category_name)
	{
		$this->category_id = $category_id;
        $this->parent_id = $parent_id;
		$this->category_name = $category_name;
	}
		public function Ready_Item_Category()
        {
$cat='<category id="'.$this->category_id.'" parentId="'.$this->parent_id.'">'.$this->category_name.'</category>
';

			return $cat;
        }
	}

?>