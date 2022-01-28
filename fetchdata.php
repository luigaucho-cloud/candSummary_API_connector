<?php
require_once 'connect.php';
//set the apikey, method,cid, cycle, and output(optional)
$apikey = ''; //enter your apikey
$output = 'json';// outpu type
$method = 'candSummary'; // nmethod used
$cid = 'N00007360';//candidate id
$cycle = 2022; //cycle (You can cahenge to a different year)

$url ="https://www.opensecrets.org/api/?method=$method&cid=$cid&cycle=$cycle&apikey=$apikey&output=$output";


$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => 'utf8',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET'
));

$response = curl_exec($curl);
//getting http_satus_code
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//if status code is not 200/OK error only error message is dispalyed
if($httpCode != 200)
{
  die($response);
}
//converting the response from json to php array
$data_array = json_decode($response,true);
//getting the attributes
$data = $data_array['response']['summary']['@attributes'];
//storing each attribute into a variable
$candidatename = $data['cand_name'];
$state = $data['state'];
$party = $data['party'];
$chamber = $data['chamber'];
$first_elected = $data['first_elected'];
$next_election = $data['next_election'];
$total = $data['total'];
$spent = $data['spent'];
$cash_on_hand = $data['cash_on_hand'];
$debt = $data['debt'];
$origin = $data['origin'];
$source =  $data['source'];
$last_updated = date("Y-m-d", strtotime($data['last_updated']));
//close connection
curl_close($curl);
try {

$mysql = 'INSERT INTO candidate_reports(cand_name,cid,cycle,state,party,chamber,first_elected,next_election,total,spent,
cash_on_hand,debt,origin,the_source,last_updated)
values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
$prepare = $pdo->prepare($mysql);
$success = $prepare->execute([$candidatename,$cid,$cycle,$state,$party,$chamber,$first_elected,$next_election,
$total,$spent,$cash_on_hand,$debt,$origin,$source,$last_updated]);
if($success)
{
  echo 'The record has been inserted into the database successfully';
}
}
//if error occurrs during database record insertion
 catch (PDOException $e) {
echo 'Data was not inserted into the database<br>'.$e->getMessage();
}

 ?>
