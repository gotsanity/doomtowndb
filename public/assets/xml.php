<?php

$db = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'username', 'password', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

$xml=simplexml_load_file("core-set.xml");


function xml2array($xmlObject, $out = [])
{
    foreach($xmlObject->attributes() as $attr => $val)
        $out['@attributes'][$attr] = (string)$val;

    $has_childs = false;
    foreach($xmlObject as $index => $node)
    {
        $has_childs = true;
        $out[$index][] = xml2array($node);
    }
    if (!$has_childs && $val = (string)$xmlObject)
        $out['@value'] = $val;

    foreach ($out as $key => $vals)
    {
        if (is_array($vals) && count($vals) === 1 && array_key_exists(0, $vals))
            $out[$key] = $vals[0];
    }
    return $out;
}

$arr = xml2array($xml);

$data = array();

foreach ($arr[card] as $k => $v) {
	$data[$k]['name'] = $v['@attributes']['name'];
	foreach ($v['property'] as $pk => $pv) {
		$value = $pv['@attributes']['value'];
		$data[$k][strtolower(str_replace(' ', '_', $pv['@attributes']['name']))] = $value;
	}
}

	$stmt = $db->prepare("INSERT INTO cards (id, name, rank, suit, type, cost, upkeep, production, bullets, bullet_bonus, draw_type, influence, control, outfit, keywords, text) VALUES ('', :name, :rank, :suit, :type, :cost, :upkeep, :production, :bullets, :bullet_bonus, :draw_type, :influence, :control, :outfit, :keywords, :text)");
foreach ($data as $k => $v) {
	if (empty($v[rank])) {
		$v[rank] = null;
		$v[suit] = null;
	}
	
	if (empty($v[cost])) {
		$v[cost] = null;
	}

	if (empty($v[upkeep])) {
		$v[upkeep] = null;
	}
	
	if (empty($v[production])) {
		$v[production] = null;
	}
	
	if (empty($v[draw_type])) {
		$v[bullets] = null;
		$v[draw_type] = null;
	}
	
	if (empty($v[bullet_bonus])) {
		$v[bullet_bonus] = null;
	}
	
	if (empty($v[influence])) {
		$v[influence] = null;
	}
	
	if (empty($v[control])) {
		$v[control] = null;
	}
	
	if (empty($v[outfit])) {
		$v[outfit] = null;
	}
	
	if (empty($v[keywords])) {
		$v[keywords] = null;
	}
	
	if (empty($v[text])) {
		$v[text] = null;
	}
	
  $stmt->bindValue(':name', $v[name], PDO::PARAM_STR);
  $stmt->bindValue(':rank', $v[rank], PDO::PARAM_STR);
  $stmt->bindValue(':suit', $v[suit], PDO::PARAM_STR);
  $stmt->bindValue(':type', $v[type], PDO::PARAM_STR);
  $stmt->bindValue(':cost', $v[cost], PDO::PARAM_INT);
  $stmt->bindValue(':upkeep', $v[upkeep], PDO::PARAM_INT);
  $stmt->bindValue(':production', $v[production], PDO::PARAM_INT);
  $stmt->bindValue(':bullets', $v[bullets], PDO::PARAM_INT);
  $stmt->bindValue(':bullet_bonus', $v[bullet_bonus], PDO::PARAM_INT);
  $stmt->bindValue(':draw_type', $v[draw_type], PDO::PARAM_STR);
  $stmt->bindValue(':influence', $v[influence], PDO::PARAM_INT);
  $stmt->bindValue(':control', $v[control], PDO::PARAM_INT);
  $stmt->bindValue(':outfit', $v[outfit], PDO::PARAM_STR);
  $stmt->bindValue(':keywords', $v[keywords], PDO::PARAM_STR);
  $stmt->bindValue(':text', $v[text], PDO::PARAM_STR);
//	$stmt->execute();
}



?>
