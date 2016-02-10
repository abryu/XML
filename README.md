The context of this assignment is aiming to gain experience of getting information from a remote server through Internet. We are assigned a very long data list and we need find the fastest way to transfer these data from server to local along with the knowledge about XML we learned in class. 

1. XML file transform
We turned the “dataset.txt” into XML file. We applied internal DTD to the XML file. We added <DATASET> as root element. 

2. Function applied: sending request to server, getting returned XML file
We use PHP to execute these two functions. We first create a blank XML file and load data in. And then code the read XML file element part. 
We use foreach to iteratively read sourceXML files DOCNO. 
Use preg_match to filter the DOCNO based on a certain pattern.
We extract the TITLE by using preg_split to separate TITLE from AUTHORS in the TEXT element.  
After we get TITLE, we will send them to the server. 
We get the response file form server then we save it and extract the PMID from the file.
We use foreach to iteratively read the PMID and get the publish year and append to XML elements.

3. XSL
After we collected the data from server, we saved the data in “5_result.xml”. We found the data appearance was not good. Then we decided to create an XSL file to customize the style appearance of “5_result.xml”. Xpath function build in xsl is applied.  Different types of data are separated by colors. For example, PMID and YEARS are separated. 

4. Result Analysis
We firstly made a mini data sheet called textData.xml to test our PHP program first. It works perfectly. Then we processed the whole dataset. Eventually, we got the predict result. The latency caused by large data flow is a great issue in accomplish process of this assignment.

Summary
We learned how to set DTD, how to transform big data flow from server to local pc through sending request, load XML file and apply XSL style sheet. In the end, we get a good look HTML page on our browser which is from the source data managed by XML file. 
