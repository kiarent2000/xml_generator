<? 
require_once('xml_prom.php');
require_once('connect.php');
$fp = fopen('my_class.xml', 'w');
$firmName = "xxxxxxxxxx";
$firmId = 'xxxxxxxx';
$rate = 1;

$sql_currency = "SELECT value   FROM oc_currency where currency_id =  2";
$result_currency = mysqli_query($conn, $sql_currency);
$row_currency = mysqli_fetch_array($result_currency);
$euro_rate = $row_currency['value'];

$sql_currency = "SELECT value   FROM oc_currency where currency_id =  3";
$result_currency = mysqli_query($conn, $sql_currency);
$row_currency = mysqli_fetch_array($result_currency);
$usd_rate = $row_currency['value'];


require_once('parts/document_start.php');
$sql_cat = "SELECT a.category_id,  a.parent_id, b.name  FROM oc_category a, oc_category_description b where b.category_id =  a.category_id";
$result_cat = mysqli_query($conn, $sql_cat);
while($row_cat = mysqli_fetch_array($result_cat)){
$new_cat=new Xml_prom_category($row_cat['category_id'], $row_cat['parent_id'], $row_cat['name']);
$a = $a.$new_cat->Ready_Item_Category();}
require_once('parts/category_end.php');
fwrite($fp, $a);
unset($a);
$sql = "SELECT DISTINCT a.product_id, a.base_price, a.base_currency_code, d.category_id, 	a.model, a.price, a.stock_status_id, c.name, c.description  FROM oc_product a, oc_product_description c, oc_product_to_category d where a.status = 1 and a.stock_status_id=7 and d.product_id =  a.product_id and c.product_id =  a.product_id  ";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
$offer_id = $row['product_id'];
$stock_status_id =  $row['stock_status_id'];     
$result_image = mysqli_query($conn, "SELECT image  FROM oc_product  where 	product_id='$offer_id' ");
while($row_image = mysqli_fetch_array($result_image)){
$picture[] = '<picture>https://xxxxxxxxxxx/image/'.$row_image['image'].'</picture>
';}
$result_image = mysqli_query($conn, "SELECT image  FROM oc_product_image  where 	product_id='$offer_id' ");
while($row_image = mysqli_fetch_array($result_image)){
$picture[] = '<picture>https://xxxxxxxxxxx/image/'.$row_image['image'].'</picture>
';}
if(empty($picture)){$picture[] = '<picture>https://xxxxxxxxxxx/image/no_image.png</picture>
';}
$result_attribute = mysqli_query($conn, "SELECT text,  attribute_id FROM oc_product_attribute  where 	product_id='$offer_id'");
while($row_attribute = mysqli_fetch_array($result_attribute)){ 
$text =  htmlentities($row_attribute['text']);    
$attribute_id =  $row_attribute['attribute_id']; 
$sql_attribute_description = "SELECT name  FROM  oc_attribute_description where attribute_id='$attribute_id'"; 
$result_attribute_description = mysqli_query($conn, $sql_attribute_description);
while($row_attribute_description = mysqli_fetch_array($result_attribute_description)){ 
$name =  htmlentities($row_attribute_description['name']);}

$pattern = "/(\&sup)/U";
$replacement = "";
$text=preg_replace($pattern, $replacement, $text);
$pattern = "/(\&sup)/U";
$replacement = "";
$name=preg_replace($pattern, $replacement, $name);


$pattern = "/(\&deg;)/U";
$replacement = "";
$text=preg_replace($pattern, $replacement, $text);
$pattern = "/(\&deg;)/U";
$replacement = "";
$name=preg_replace($pattern, $replacement, $name);



$description = $row['description'];
$pattern = "/(url)(.*)(\))/U";
$replacement = "";
$description=preg_replace($pattern, $replacement, $description);

$pattern = "/(<a)(.*)(>)/U";
$replacement = "";
$description=preg_replace($pattern, $replacement, $description);



$param[]= '<param name="'.$name.'"><![CDATA['.$text.']]></param>
';
if($name=="Производитель"){$vendor=	'<![CDATA['.$text.']]>';}
unset($name, $text, $attribute_id);}

if($row['base_currency_code'] =='USD'):
$price  = $row['base_price']/$usd_rate;
else:
$price  =  $row['price'];
endif;

if($row['base_currency_code'] =='EUR'):
$price  = $row['base_price']/$euro_rate;
else:
$price  =  $row['price'];
endif;


$one_item = new Xml_prom($rate, $offer_id, ($stock_status_id==7) ? "true" :  "false", $price, $param, 'https://xxxxxxxxxxx/index.php?route=product/product&product_id='.$offer_id, "UAH", $row['category_id'], $picture, '<![CDATA['.$row['name'].']]>', $vendor, $row['model'], '<![CDATA['.$description.']]>');
$a = $one_item->Ready_Item();
fwrite($fp, $a);
unset($a, $param, $picture);
}

require_once('parts/document_end.php');
fwrite($fp, $a);

