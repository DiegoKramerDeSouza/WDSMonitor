import-module activedirectory

$computers = get-adcomputer -filter * -properties *
$path = "C:\xampp\htdocs\wdsmonitor\logs"
$filecontent = ""
$logPath = "{0}\temp.mddb" -f $path
$target = "{0}\computers\computers.mddb" -f $path
foreach($computer in $computers){
	#$created = $computer.created
	#$createdY = [datetime]::FromFileTime($created).ToString('yyyy')
	#$createdM = [datetime]::FromFileTime($created).ToString('MM')
	#$createdD = [datetime]::FromFileTime($created).ToString('dd')
	$createdD = ($computer.created).day
	$createdM = ($computer.created).month
	$createdY = ($computer.created).year
	$created = "{0}/{1}/{2}" -f $createdD, $createdM, $createdY
	
	#$lastlogon = $computer.lastLogonTimestamp
	#$lastlogonY = [datetime]::FromFileTime($lastlogon).ToString('yyyy')
	#$lastlogonM = [datetime]::FromFileTime($lastlogon).ToString('MM')
	#$lastlogonD = [datetime]::FromFileTime($lastlogon).ToString('dd')
	$lastlogon = [datetime]::FromFileTime($computer.lastLogonTimestamp).ToString('g')
	
	$name = $computer.name
	$os = $computer.operatingsystem
	if($os -notlike "*windows*"){
		"#{0}|{1}|{2}" -f $name, $created, $lastlogon >> $logPath
	} else {
		"#{0}|{1}|{2}|{3}" -f $name, $os, $created, $lastlogon >> $logPath
	}
}

move-item -path $logPath -destination $target -force

