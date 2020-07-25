<?php

$crawl_url = 'https://www.google.com/';

$visited_sites = [];

function crawl($crawl_url,&$visited_sites){
	$visited_sites[] = $crawl_url;
	$options = array(
				  'http'=>array(
				    'method'=>"GET",
				    'header'=>"User-Agent: Basic Web Crawler\n" 
				  )
				);

	$dom = new DOMDocument();
	@$dom->loadHTML(file_get_contents($crawl_url,false,stream_context_create($options)));
	$site_details = [];
	$site_details['site']  = $crawl_url;
	$site_details['title'] = $dom->getElementsByTagName('title')->item(0)->nodeValue;
	foreach($dom->getElementsByTagName('meta') as $each_node){
		if(strtolower($each_node->getAttribute('name')) === 'description'){
			$site_details['description'] = $each_node->getAttribute('content');
		}else if(strtolower($each_node->getAttribute('name')) === 'keywords' || strtolower($each_node->getAttribute('name')) === 'keyword'){
			$site_details['keywords'] = $each_node->getAttribute('content');
		}
	}	

	print_r($site_details);
	
	foreach(getHyperlinks($crawl_url,$dom) as $each_link){
		if(!in_array($each_link,$visited_sites)){
			crawl($each_link,$visited_sites);
		}
	}
}

function getHyperlinks($crawl_url,$dom_obj){
	$result = [];
	foreach($dom_obj->getElementsByTagName('a') as $each_node){
		$url = $each_node->getAttribute('href');
		if(substr($url,0,2) === '//'){
			$result[] = parse_url($crawl_url)['scheme'].":".$url;
		}else if(substr($url,0,1) === '/'){
			$result[] = parse_url($crawl_url)['scheme']."://".parse_url($crawl_url)['host'].$url;
		}else if(substr($url,0,1) === '#'){
			$result[] = parse_url($crawl_url)['scheme']."://".parse_url($crawl_url)['host']."/".ltrim(parse_url($crawl_url)['path'],"/").$url;
		}else if(substr($url,0,4) === 'http'){
			$result[] = $url;
		}
	}

	return $result;
}

crawl($crawl_url,$visited_sites);



