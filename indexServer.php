<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ITEC4020 Assignment 1</title>
    </head>
    <body>     
        <?php
            //load the source file
            $sourceXML=simplexml_load_file("ITEC4020-A1-dataset.xml") or die("Error: Sorry, we cannot find the source file"); 
            
            //create the result xml file
            $resultXML = new DOMDocument("1.0", "UTF-8");
            
            //create the root node for the resultXML
            $rootElement = $resultXML->createElement("ROOT"); 

            //append the root node to the resultXML
            $resultXML->appendChild($rootElement);
            
            //saving the file 
            $resultXML->save("group5_result.xml");  


            //The next part is about: Extract TITLE in sourceXML

            //Reference: http://www.w3schools.com/php/php_xml_simplexml_get.asp
            //           http://php.net/manual/en/function.preg-match.php
            //           http://php.net/manual/en/function.preg-split.php


            foreach($sourceXML->children() as $docNum) {

                if (preg_match("/\d+_0\.\d+/", $docNum->DOCNO)){

                    //Create elements in resultXML
                    $docElement = $resultXML->createElement('DOC');
                    $docnoElement = $resultXML->createElement('DOCNO');
                    $titleElement = $resultXML->createElement('TITLE');
                    $authorsElement = $resultXML->createElement('AUTHORS');
                    $detailsElement = $resultXML->createElement('DETAILS');


                    //Arrange those elements under ROOT
                    $rootElement->appendChild($docElement);
                    $docElement->appendChild($docnoElement);
                    $docElement->appendChild($titleElement);
                    $docElement->appendChild($authorsElement);
                    $docElement->appendChild($detailsElement);

                    //When the resultXML displays, there is no space between title and authors. We cannot distinguish the author infomation
                    //So we examine the sourceXML and find certain patterns in TEXT. i.e. There are centain spaces between TITLE and AUTHOR
                    $titleToBeExtracted = trim($docNum->TEXT);
                    $arrayForTEXT = preg_split('/    /', $titleToBeExtracted, 2);

                    //Split the $titleToBeExtracted and store it into an array form.
                    //If the array length = 1, it means no pattern matched (i.e. no authors). The fist element is TITLE
                    //If the array length = 2, it means the first element is TITLE and the second element is author(s)
                    
                    if(count($arrayForTEXT) == 1) {
                        $titleToBeSearched = $arrayForTEXT[0];
                    } else {
                        //In the sourceXML, some TEXT's beginning are about Introduction then the content.
                        //If we find such pattern, we set TITLE to be its actual content.
                        //http://php.net/manual/en/function.strpos.php
                        if (strpos($arrayForTEXT[0],'Introduction')) {
                            $titleToBeSearched = $arrayForTEXT[1];
                        } else {
                            $titleToBeSearched = $arrayForTEXT[0];                            
                        }    
                    }

                    //set resultXML nodes' value
                    $docnoElement->nodeValue = $docNum->DOCNO;
                    $titleElement->nodeValue = $titleToBeSearched;    
                    if(count($arrayForTEXT) == 2) {
                        $authorsElement->nodeValue = $arrayForTEXT[1];
                    }

                    //The next part is about send TITLE to server and get its content
                    //http://php.net/manual/en/function.urlencode.php
                    $formattedTitle = urlencode($titleToBeSearched);
                    $titleSearchXML = file_get_contents("http://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=pubmed&term=".$formattedTitle);
                    $titleSearchXML = new SimpleXMLElement($titleSearchXML);

                    if(isset($titleSearchXML->IdList)) {
                        //After we get the returnedFile, we extract its Id in IdList and send to server.
                        foreach($titleSearchXML->IdList->children() as $idToSearch) {

                            $idSearchXML = file_get_contents("http://eutils.ncbi.nlm.nih.gov/entrez/eutils/esummary.fcgi?db=pubmed&id=".$idToSearch);
                            $idSearchXML = new SimpleXMLElement($idSearchXML);

                            $publishedYear = preg_split("/ /", $idSearchXML->DocSum->Item);
                            $idNumber = $resultXML->createElement('ITEMS');

                            $detailsElement->appendChild($idNumber);

                            $pmidOptionalElement = $resultXML->createElement('PMID');

                            $publishedYearOptionalElement = $resultXML->createElement('PUBLISHED_YEAR');
                            $idNumber->appendChild($pmidOptionalElement);

                            $idNumber->appendChild($publishedYearOptionalElement);

                            $pmidOptionalElement->nodeValue = $idSearchXML->DocSum->Id;
                            $publishedYearOptionalElement->nodeValue = $publishedYear[0];   
                        }
                    }
                }


            }

            //check the resultXML format
            $resultXML->save("group5_result.xml");
            header('Location: group5_result.xml');

            echo 'The result file created and saved successfully';     
            /*
                <?xml-stylesheet type="text/xsl" href="styleForXML.xsl"?>
            */
        ?>
    </body>
</html>
