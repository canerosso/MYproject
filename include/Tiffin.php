	<?php

	//error_reporting(0);
	@session_start();
	require_once 'Config.php';
	require_once 'DatabaseConnection.php';
	require_once  'Crud.php';
	require_once  'Utils.php';
	//ini_set('display_errors', 1);
	//ini_set('error_reporting', E_ALL);
	/**
	* 
	*/

	   class Tiffin extends Crud
	   {
		# Database Connection Variable 	
	          var $databaseConnection = NULL;
	          var $tableName;
  

	        # Constructor 
	        function __construct(){
		# Make database connection 
		$databaseObject = new DatabaseConnection();
		$this->databaseConnection = $databaseObject->getDatabaseInstance(SERVER_API_KEY); 
            
                }
                 
          
          ##CREATE TIFFIN BY VENDOR###  ##(tiffin detail)
		  public function createTiffin($params)
		  {
			
            $fields = array_keys($params);
			$values = array_values($params);
	        return parent::insertData(TABLE_VENDOR_TIFFIN,$fields,$values);
		   }

           ##INSERT THE CREATED TIFFIN INTO DB BY VENDOR### ##(Tiffin content detail)
		  public function insertTiffin($param){
                       
              $arrnew=explode(",",$param['meal_type_content_id']);
              $tiffin_id=$param['tiffin_content_id'];
               $quantity=explode(",",$param['quantity']);
                     
      		   $c=count($arrnew);  
                for($i=0;$i<$c;$i++)
                  { 	
                  	$params['meal_type_content_id'] =$arrnew[$i];
	    	        $params['tiffin_content_id'] =$tiffin_id;
			        $params['quantity']=$quantity[$i];
			        $fields = array_keys($params);
			        $values = array_values($params);
			        parent::insertData(TABLE_VENDOR_TIFFIN_CONTENT,$fields,$values);
			       }
		   }

		     ##INSERT TAGGING (Tiffin content detail)
		  public function inserttag($param){
                       
              $arrnew=explode(",",$param['tag_id']);
              $tiffin_id=$param['vendors_tiffin_id'];
                     
      		   $c=count($arrnew);  
                for($i=0;$i<$c;$i++)
                  { 	
                  	$params['tag_id'] =$arrnew[$i];
	    	        $params['vendors_tiffin_id'] =$tiffin_id;
			        $fields = array_keys($params);
			        $values = array_values($params);
			        parent::insertData(TABLE_VENDOR_TIFFIN_TAGGING,$fields,$values);
			       }
		   }

           ##INSERT PLACES FOR CREATED TIFFIN INTO DB BY VENDOR### ##(Tiffin places selected by the vendor)
			public function insertPlace($param,$param1){
            $cnt=count($param);
			$i=0;
            while($i<$cnt)
			  {
			  $params['tiffin_place'] =$param[$i];
				$i++;   
	    	  $params['tiffin_time'] =rawurldecode($param[$i]);
			  $params['vendor_tiffin_id']=$param1['tiffin_id'];
              $params['created_at']=Utils::getCurrentDateTime();
              $params['modified_at']=Utils::getCurrentDateTime();
              $params['status']=1; 
			  $fields = array_keys($params);
			  $values = array_values($params);
		      parent::insertData(TABLE_VENDOR_TIFFIN_PLACES,$fields,$values);
                            $i++;
             }
                  
		 }

          ###SCHEDULE TIFFIN BY VENDOR FOR PARTICULAR DATE###  (Tiffin schedule by vendor for particular date)
          public function addTiffin($params){
			$fields = array_keys($params);
			$values = array_values($params);
	        return parent::insertData(TABLE_TFIN_MENU,$fields,$values);
		 }

	  	 function displayBreakfast($flag){
       		  $displaymealtype = "SELECT a.id, a.tiffin_name,c.name FROM vendors_tiffin a, vendors_tiffin_content b,meal_type_content c
	                WHERE  a.id = b.tiffin_content_id and c.id=b.meal_type_content_id and a.tiffin_description ='breakfast'";
			try{
			      $selectStatement = $this->databaseConnection->prepare($displaymealtype);
			      $selectStatement->execute();
			      $eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);
				return $eventsInfo;
			   }
		        catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		 }

		function displayLunch($flag)
		{
    		$displaymealtype = "SELECT a.id,a.tiffin_name FROM vendors_tiffin a, vendors_tiffin_content b, meal_type_content c
		 WHERE a.tiffin_description = 'lunch'AND a.id = b.tiffin_content_id AND c.id = b.meal_type_content_id GROUP BY a.id ";
			try{
			     $selectStatement = $this->databaseConnection->prepare($displaymealtype);
			     $selectStatement->execute();
			     $eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);
				return $eventsInfo;
			   }
		        catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}

		function displayDinner($flag){
		$displaymealtype = "SELECT a.id,a.tiffin_name FROM vendors_tiffin a, vendors_tiffin_content b, meal_type_content c
		WHERE a.tiffin_description = 'dinner' AND a.id = b.tiffin_content_idAND c.id = b.meal_type_content_id GROUP BY a.id";
			try{
 			      $selectStatement = $this->databaseConnection->prepare($displaymealtype);
			      $selectStatement->execute();
			      $eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);
				return $eventsInfo;
			    }
		    catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}

		/*function getTiffinMenu($date){
			$result=array();
        $displaybreakfast = "SELECT c.name
						FROM tifin_menu a, vendors_tiffin_content b, meal_type_content c
					WHERE date = '".$date."' and a.breakfast = b.tiffin_content_id
					and  b.meal_type_content_id = c.id ";
        $displaylunch = "SELECT c.name
						FROM tifin_menu a, vendors_tiffin_content b, meal_type_content c
					WHERE date = '".$date."' and a.lunch = b.tiffin_content_id
					and  b.meal_type_content_id = c.id ";	
        $displaydinner = "SELECT c.name
						FROM tifin_menu a, vendors_tiffin_content b, meal_type_content c
					WHERE date = '".$date."' and a.dinner = b.tiffin_content_id
					and  b.meal_type_content_id = c.id ";										
			try{

				$selectStatement = $this->databaseConnection->prepare($displaybreakfast);
				$selectStatement->execute();
				$eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);
                   $arr1 = (array)$eventsInfo;
				$selectStatement1 = $this->databaseConnection->prepare($displaylunch);
				$selectStatement1->execute();
				$eventsInfo1 = $selectStatement1->fetchAll(PDO::FETCH_OBJ);
				  $arr2 = (array)$eventsInfo1;
				$selectStatement2= $this->databaseConnection->prepare($displaydinner);
				$selectStatement2->execute();
				$eventsInfo2 = $selectStatement2->fetchAll(PDO::FETCH_OBJ);
				  $arr3 = (array)$eventsInfo2;

				$result=array($arr1,$arr2,$arr3);
				
		    	return $result;
				}

		    catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}
*/
		function getBreakfast($date){
		 $displaybreakfast="select a.vendor_id,c.name from vendors_tiffin a, vendors_tiffin_content b,meal_type_content c,
                 tifin_menu d where a.id=b.tiffin_content_id and c.id=b.meal_type_content_id and d.breakfast=b.tiffin_content_id 
		 and d.date='".$date."' and a.vendor_id= $_SESSION[id]";				
			try{
			     $selectStatement = $this->databaseConnection->prepare($displaybreakfast);
			     $selectStatement->execute();
			     $eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);				
		    	       return $eventsInfo;
			   }
		         catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			 }
		   }

		function getLunch($date){
	        $displaylunch = "select a.vendor_id,c.name from vendors_tiffin a, vendors_tiffin_content b,meal_type_content c, tifin_menu d 
		where a.id=b.tiffin_content_id and c.id=b.meal_type_content_id and d.lunch=b.tiffin_content_id and d.date='".$date."'
		 and a.vendor_id= $_SESSION[id]";
       			try{
			      $selectStatement = $this->databaseConnection->prepare($displaylunch);
			      $selectStatement->execute();
			      $eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);
			      return $eventsInfo;
			   }
		        catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		 }

		function getDinner($date){
        	$displaybreakfast = "select a.vendor_id,c.name from vendors_tiffin a, vendors_tiffin_content b,meal_type_content c, 
		tifin_menu d where a.id=b.tiffin_content_id and c.id=b.meal_type_content_id and d.dinner=b.tiffin_content_id 
		and d.date='".$date."' and a.vendor_id= $_SESSION[id]";				
			try{
			      $selectStatement = $this->databaseConnection->prepare($displaybreakfast);
			      $selectStatement->execute();
			      $eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);				
		    	      return $eventsInfo;
			  }
		        catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}
		
		function getArea($date){	
       	        $getArea="SELECT a.tiffin_place from vendors_tiffin a,tifin_menu b where a.vendor_id= $_SESSION[id] 
		and b.date='".$date."'";								
			try{
				$selectStatement = $this->databaseConnection->prepare($getArea);
				$selectStatement->execute();
				$eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);				
		    		return $eventsInfo;
			  }
		        catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}

		function getVendor($flag){
		$getVendor="SELECT id,name from users where user_type='4'and 							           					status='1'";								
			try{
			      $selectStatement = $this->databaseConnection->prepare($getVendor);
			      $selectStatement->execute();
			      $eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);	
				if($flag==1)
				{
					return $eventsInfo;
				}			    	
			} 
		       catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		 }

		function getBreakfastForAdmin($date,$id){
	        $displayBreakfastForAdmin = "select a.vendor_id,c.name from vendors_tiffin a,vendors_tiffin_content b,meal_type_content c, 			tifin_menu d where a.id=b.tiffin_content_id and c.id=b.meal_type_content_id and d.breakfast=b.tiffin_content_id 
		and d.date='".$date."' and a.vendor_id=".$id."";					
			try{
			       $selectStatement = $this->databaseConnection->prepare( $displayBreakfastForAdmin);
			       $selectStatement->execute();
			       $eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);				
     		    		return $eventsInfo;
			   }
		        catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		 }

		function getLunchForAdmin($date,$id){
        	$getLunchForAdmin = "select a.vendor_id,c.name from vendors_tiffin a,vendors_tiffin_content b,meal_type_content c,
		tifin_menu d where a.id=b.tiffin_content_id and c.id=b.meal_type_content_id and d.lunch=b.tiffin_content_id 
	        and d.date='".$date."' and a.vendor_id=".$id."";								
			try{
			      $selectStatement = $this->databaseConnection->prepare($getLunchForAdmin);
			      $selectStatement->execute();
			      $eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);				
		    	      return $eventsInfo;
			    }
		        catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}

		function getdinnerForAdmin($date,$id){
	        $getdinnerForAdmin = "select a.vendor_id,c.name from vendors_tiffin a,vendors_tiffin_content b,meal_type_content c,
                tifin_menu d where a.id=b.tiffin_content_id and c.id=b.meal_type_content_id and d.dinner=b.tiffin_content_id 
		and d.date='".$date."' and a.vendor_id=".$id."";								
			try{
 			     $selectStatement = $this->databaseConnection->prepare($getdinnerForAdmin);
			     $selectStatement->execute();
			     $eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);				
		    	     return $eventsInfo;
			   }
		        catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}
        
        ###DISPLAY TIFFIN FOR SUPERADMIN###
		  public function viewTifffin($id){
		 $viewTiffin="select a.date,a.vendor_id,b.tiffin_name from tifin_menu a,vendors_tiffin b
		  where b.vendor_id='".$id."'and (a.lunch=b.id or a.breakfast=b.id or a.dinner=b.id)";
		         try{
				$selectStatement = $this->databaseConnection->prepare($viewTiffin);
				$selectStatement->execute();
				$eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);	
					return $eventsInfo;
			   }

		        catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}

         ##ADD TIFFIN PLACE FROM PROFILE MENU BY VENDOR###
		 public function addTiffinPlace($params){
			$fields = array_keys($params);
			$values = array_values($params);

	         
	         return parent::insertData(TABLE_TFIN_PLACE,$fields,$values);
		}
   
         ##DISPLAY TIFFIN PLACE FOR CREATE TIFFIN FOR VENDOR ON PROFILE PAGE##
		 public function displayPlace(){	
       		$displayPlace = "SELECT distinct place_name,id FROM tiffin_place WHERE 
		                    vendor_id=".$_SESSION['id']." ORDER BY `place_name` ASC";									
			try{
				return parent::excuteQuery($displayPlace);
			   }
		        catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}

		##DISPLAY ALL LOCATIONS IN DROPDOWN ON PROFILE PAGE FOR VENDOR###
		public function getAllLoactions(){
   	         $getAllLoactions="SELECT location_id,location FROM locations where
   	          location not in(SELECT place_name FROM tiffin_place WHERE vendor_id=".$_SESSION['id'].")";								
			try{
                   return parent::excuteQuery($getAllLoactions);
			    }

		    catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		 }

		 	public function getAlluser(){
   	        
		 	$whereClauseArray['id'] = $_SESSION['id'];
		 	$orderBy['id'] = "ASC";	
   	        

			try{
                 return  parent::getData(TABLE_USER,"*",$whereClauseArray,$orderBy);
			    }

		    catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		 }
		 

                
		##DELETE DELIVERY AREA FROM PROFILE PAGE OF VENDOR###
		function  deletedeleteDeliveryPlace($sid){
	    $deletedeleteDeliveryPlace = "delete FROM tiffin_place where id='".$sid."'";
			try{
                return parent::excuteQuery1($deletedeleteDeliveryPlace);
				}catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			   }
		 }
		  ##DISPLAY TAGGING FOR CREATE TIFFIN FOR VENDOR ON CREATE TIFFIN PAGE##
		 public function displayTags(){	
       		$displayTags = "SELECT id,tag_name FROM `tagging`";									
			try{
				return parent::excuteQuery($displayTags);
			   }
		        catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}

		 ##DISPLAY EXISTING TIFFIN FOR CREATE TIFFIN FOR VENDOR ON CREATE TIFFIN PAGE##
		 public function displayTiffinName(){	
          

       		$displayTiffinName = "SELECT id,tiffin_name FROM vendors_tiffin where vendor_id='".$_SESSION['id']."' ORDER BY `tiffin_name`";									
			try{
				return parent::excuteQuery($displayTiffinName);
			   }
		        catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}
public function displayTiffinName2($name){	
          

       		$displayTiffinName2 = "SELECT id,tiffin_name FROM vendors_tiffin where tiffin_name='".$name."' ORDER BY `tiffin_name`";									
			try{
				return parent::excuteQuery($displayTiffinName);
			   }
		        catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}


		public function isexistName($name){	
        $fields = array('id','tiffin_name');
        $tableName=TABLE_VENDOR_TIFFIN;
        $whereclause=array('tiffin_name' => $name);
       // $whereClauseArray['tiffin_name']= $name;

        $orderby="";
	    try
	    {
	     return parent::getData($tableName,$fields,$whereclause,$orderby);
	    }
		 catch(Exception $e)
		    {
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}

		###########DELETE CREATED TIFFIN BY VENDOR ON CREATE TIFFIN PAGE ###########
		 function  deleteCreatedTiffin($sid){
		 $deleteCreatedTiffin = "delete FROM  `vendors_tiffin` where id=".$sid." ";
			try{
				$selectStatement = $this->databaseConnection->prepare($deleteCreatedTiffin);
			     $eventsInfo=$selectStatement->execute();
				//$eventsInfo = $selectStatement->fetchAll(PDO::FETCH_OBJ);
					return $eventsInfo;
				}catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			   }
		 }

		  //**UPDATE ITEM(BREAKFAST,BREAD,RICE,SABJI,DAL)***//
		
		function updateTiffin($params){
			
           
			$temporary_id = $params['id'];
			
			$params['id'] =  $temporary_id;
			$fields = array_keys($params);
			$values = array_values($params);

			return parent::updateData(TABLE_VENDOR_TIFFIN,$fields,$values,1);
		}

		 ##DISPLAY BREAKFAST ITEM  FOR VIEW TIFFIN FOR VENDOR ON SHOW TIFFIN PAGE##
		 public function displayBreakfastItem($date){

      $displayBreakfastItem = "SELECT d.name FROM tifin_menu a, vendors_tiffin b,
       		vendors_tiffin_content c, meal_type_content d WHERE a.date ='".$date."'
            AND a.breakfast = b.id AND c.tiffin_content_id = b.id  AND 
            c.meal_type_content_id = d.id";									
			try{
				return parent::excuteQuery($displayBreakfastItem);
			   }
		        catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}
		##DISPLAY LUNCH ITEM  FOR VIEW TIFFIN FOR VENDOR ON SHOW TIFFIN PAGE##
		 public function displayLunchItem($date){

      $displayLunchItem = "select b.tiffin_name from tifin_menu a,vendors_tiffin b where a.date='".$date."' and a.lunch=b.id ";									
			try{
				return parent::excuteQuery($displayLunchItem);
			   }
		        catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}		
		}

		##DISPLAY DINNER ITEM  FOR VIEW TIFFIN FOR VENDOR ON SHOW TIFFIN PAGE##
		 public function displayDinnerItem($date){

      $displayDinnerItem= "select b.tiffin_name from tifin_menu a,vendors_tiffin b where a.date='".$date."' and a.dinner=b.id  ";									
			try{
				return parent::excuteQuery($displayDinnerItem);
			   }
		        catch(Exception $e){
				echo $e->getMessage();
				return TAG_RESPONSE_BAD;
			}
		}
}
?>