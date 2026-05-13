<?php
$db=new PDO('sqlite:d:/Tp_CI4/RH/writable/db/db.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$email='autotest'.time().'@example.test';
// Ensure we have a valid departement_id (schema may require NOT NULL)
$deptRow = $db->query('SELECT id FROM departements LIMIT 1')->fetch(PDO::FETCH_ASSOC);
if (!$deptRow) {
    $db->prepare('INSERT INTO departements (nom,description,deductible) VALUES (?,?,?)')
        ->execute(['Général','Département par défaut',0]);
    $departement_id = $db->lastInsertId();
} else {
    $departement_id = $deptRow['id'];
}

$stmt=$db->prepare('INSERT INTO employes (nom,prenom,email,password,role,departement_id,date_embauche,actif) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
$stmt->execute(['Auto','Test',$email,password_hash('secret',PASSWORD_DEFAULT),'employe',$departement_id,date('Y-m-d'),1]);
$newId=$db->lastInsertId();
echo "Inserted employe id={$newId}\n";
foreach($db->query('SELECT * FROM TypeConger') as $type){
    $typeId=$type['id'];
    $sample=null;
    $q=$db->query("SELECT jours_attribues FROM Soldes_emp WHERE type_conger_id={$typeId} LIMIT 1");
    foreach($q as $s){ $sample=$s; break; }
    if($sample){ $jours=(int)$sample['jours_attribues']; }
    else{
        $name=strtolower($type['nom'] ?? '');
        if(strpos($name,'annuel')!==false) $jours=30;
        elseif(strpos($name,'maladie')!==false) $jours=10;
        elseif(strpos($name,'spécial')!==false || strpos($name,'special')!==false) $jours=5;
        else $jours=0;
    }
    $db->prepare('INSERT INTO Soldes_emp (employe_id,type_conger_id,solde,jours_attribues,jour_prises) VALUES (?,?,?,?,?)')
        ->execute([$newId,$typeId,$jours,$jours,0]);
    echo "Inserted solde type={$typeId} jours={$jours}\n";
}
foreach($db->query('SELECT id,employe_id,type_conger_id,jours_attribues,solde,jour_prises FROM Soldes_emp WHERE employe_id='.$newId) as $r){
    echo $r['id'].'|'.$r['employe_id'].'|'.$r['type_conger_id'].'|'.$r['jours_attribues'].'|'.$r['solde'].'|'.$r['jour_prises']."\n";
}
