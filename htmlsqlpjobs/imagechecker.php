<?php
 function url_validate( $link )
   {        
       $url_parts = @parse_url( $link );

       if ( empty( $url_parts["host"] ) ) return( false );

       if ( !empty( $url_parts["path"] ) )
       {
           $documentpath = $url_parts["path"];
       }
       else
       {
           $documentpath = "/";
       }

       if ( !empty( $url_parts["query"] ) )
       {
           $documentpath .= "?" . $url_parts["query"];
       }

       $host = $url_parts["host"];
			 if (isset($url_parts["port"])){
				$port = $url_parts["port"];
			}else{
				$port = "80";
			}
       // Now (HTTP-)GET $documentpath at $host";

       
       $socket = @fsockopen( $host, $port, $errno, $errstr, 30 );
       if (!$socket)
       {
           return(false);
       }
       else
       {
           fwrite ($socket, "HEAD ".$documentpath." HTTP/1.0\r\nHost: $host\r\n\r\n");
           $http_response = fgets( $socket, 22 );
           
           if ( ereg("200 OK", $http_response, $regs ) )
           {
               return(true);
               fclose( $socket );
           } else
           {
//                echo "HTTP-Response: $http_response<br>";
               return(false);
           }
       }
   }
	 
function ImageExists($image){
	$base="http://www.peshawarjobs.com/jobimg";	
	$link="$base/$image";	
	$validurl= url_validate( $link ); 
	return $validurl;
}

