<?php 

class Report {
	private $_execlude = [
		"Sammanfattning"
	];

	private $_include = [
		"Trafikolycka",
		"Misshandel",
		"Skadegörelse",
		"Mord/dråp"
	];

	private $_links = [
			"blekinge" => [
				"name" => "Blekinge",
				"links" => "https://polisen.se/Stockholms_lan/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Blekinge---RSS-lank/"
			],
			"dalarna" => [
				"name" => "Dalarna",
				"link" => "https://polisen.se/Stockholms_lan/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Dalarna---RSS-lank/"
			],
			"gotland" => [
				"name" => "Gotland",
				"link" => "https://polisen.se/Stockholms_lan/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Gotland---RSS-lank/"
			],
			"gavleborg" => [
				"name" => "Gävleborg",
				"link" => "https://polisen.se/Stockholms_lan/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Gavleborg---RSS-lank1/"
			],
			"halland" => [
				"name" => "Halland",
				"link" => "https://polisen.se/Stockholms_lan/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Halland--RSS-lank/",
			],
			"jamtland" => [
				"name" => "Jämtland",
				"link" => "https://polisen.se/Jamtland/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Jamtland---RSS-lank1/"
			],
			"jonkoping" => [
				"name" => "Jönköping",
				"link" => "https://polisen.se/Stockholms_lan/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Jonkoping---RSS-lank1/"
			],
			"kalmar" => [
				"name" => "Kalmar",
				"link" => "https://polisen.se/Kalmar_lan/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Kalmar---RSS-lank1/"
			],
			"kronoberg" => [
				"name" => "Kronoberg",
				"link" => "https://polisen.se/Kronoberg/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Kronoberg---RSS-lank/"
			],
			"norrbotten" => [
				"name" => "Norrbotten", 
				"link" => "https://polisen.se/Norrbotten/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Norrbotten---RSS-lank1/"
			],
			"skane" => [
				"name" => "Skåne",
				"link" => "https://polisen.se/Skane/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Skane---RSS-lank1/"
			],
			"stockholm" => [
				"name" => "Stockholm",
				"link" => "https://polisen.se/Stockholms_lan/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Stockholm---RSS-lank1/"
			],
			"sodermanland" => [
				"name" => "Södermanland",
				"link" => "https://polisen.se/Stockholms_lan/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Sodermanland---RSS-lank1/"
			],
			"uppsala" => [
				"name" => "Uppsala",
				"link" => "https://polisen.se/Stockholms_lan/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Uppsala---RSS-lank1/"
			],
			"varmland" => [
				"name" => "Värmland",
				"link" => "https://polisen.se/Stockholms_lan/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Varmland---RSS-lank1/"
			],
			"vasterbotten" => [
				"name" => "Västerbotten",
				"link" => "https://polisen.se/Stockholms_lan/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Vasterbotten---RSS-lank1/"
			],
			"vasternorrland" => [
				"name" => "Västernorrland",
				"link" => "https://polisen.se/Stockholms_lan/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Vasternorrland---RSS-lank1/"
			],
			"vastmanland" => [
				"name" => "Västmanland",
				"link" => "https://polisen.se/Stockholms_lan/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Vastmanland---RSS-lank1/"
			],
			"vastra-gotaland" => [
				"name" => "Västra götaland",
				"link" => "https://polisen.se/Stockholms_lan/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Vastra-Gotaland---RSS-lank/"
			],
			"orebro-lan" => [
				"name" => "Örebro län",
				"link" => "https://polisen.se/Stockholms_lan/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Orebro---RSS-lank/"
			],
			"ostergotland" => [
				"name" => "Östergötland",
				"link" => "https://polisen.se/Stockholms_lan/Aktuellt/RSS/Lokal-RSS---Handelser/Lokala-RSS-lankar/Handelser---Ostergotland---RSS-lank/"
			]
		];
	private $_reports;
	private $_statisticsToday = [];
	private $_statisticsAll = [];

	public function __construct($area, $date) {
		$this->build($area, $date);
	}

	private function contains($str)
	{
	    foreach($this->_execlude as $execlude_word) {
	        if (strpos($str, $execlude_word) !== false) 
	        	return true;
	    }
	    
	    return false;
	}

	private function addToToday($title) {
		$title = trim($title);
		if (!$this->contains($title)) {
			if (!empty($this->_statisticsToday[$title])) {
				$this->_statisticsToday[$title] += 1;
			} else {
				$this->_statisticsToday[$title] = 1;
			}
		}			
	}

	private function addToAll($title) {
		$title = trim($title);
		if (!$this->contains($title)) {
			if (!empty($this->_statisticsAll[$title])) {
				$this->_statisticsAll[$title] += 1;
			} else {
				$this->_statisticsAll[$title] = 1;
			}
		}			
	}

	public function getArrayOfAreas() {
		return $this->_links;
	}

	public function sortStatistics() {
		ksort($this->_statisticsAll);
		ksort($this->_statisticsToday);
	}

	private function build($area, $date) {
		try {
			$xml = new SimpleXMLElement(file_get_contents($this->_links[$area]["link"]));
			$json = json_encode($xml);
			$array = json_decode($json, true);

			$items = $array["channel"]["item"];

			$items_new = [];

			foreach ($items as $item) {
				$x = new stdClass();

				$info = explode(",", $item['title']);

				$x->title = $info[1];
				$x->area = $info[2];
				$x->link = $item['link'];
				$x->description = $item['description'];
				$x->pubDate = date("Y-m-d h:i",strtotime($item["pubDate"]));

				preg_match("/(\d\d\d\d-\d\d-\d\d) (\d\d:\d\d)/", $info[0], $datetime);
				$x->date = $datetime[1];
				$x->time = $datetime[2];

				if ($date == $x->date) {
					array_push($items_new, $x);
					$this->addToToday($x->title);
				}

				$this->addToAll($x->title);
			}
			$this->_reports = $items_new;
			$this->sortStatistics();

		} catch (Exception $e) {
			echo 'Couldnt fetch data.';
		}
	}

	public function get() {
		return ["reports" => $this->_reports, "statisticsAll" => $this->_statisticsAll, "statisticsToday" => $this->_statisticsToday];
	}
}

if (isset($_GET["area"])) {
	$area = $_GET["area"];
	$date = date("Y-m-d");
	
	$report = new Report($area, $date);

	echo json_encode($report->get());
}