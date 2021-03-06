<?php
	require_once 'Controller.php';
	class ControllerAdminCreateBook extends Controller{

		public $model;

		public function invoke(){
			$data = array('title'=>'Create New Book Entry');
			$this->loadModel('ModelAdmin');
			$this->model = new ModelAdmin();

			if(!isset($_POST['btnCreateBook'])){
				// get initial datalist values LIMIT of 10
				$data['maxBookNumber'] = $this->model->getMaxBookNumber();
				$data['bookNumbers'] = $this->model->getBookNumbers(); #array
				$data['isbns'] = $this->model->getISBNs(); #array
				$data['titles'] = $this->model->getTitles(); #array
				$data['authors'] = $this->model->getAuthors(); #array
				$data['publishers'] = $this->model->getPublishers(); #array
				$data['source'] = $this->model->getSourceOfFunds(); #array
				$data['class'] = $this->model->getClasses(); #array
				$data['remarks'] = $this->model->getRemarks(); #array

				$this->loadView('head',$data);
				$this->loadView('navbar',$data);
				$this->loadView('create_book',$data);	
				$this->loadView('footer',null);	
			}
			# execute on form submit 'save'
			else{
				# basic info
				$bookNumber = $_POST['bookNumber'];
				$isbn = $_POST['isbn'];
				$title = $_POST['title'];
				$author = $_POST['author'];
				$publisher = $_POST['publisher'];
				# core info
				$description = $_POST['description'];
				$pages = $_POST['pages'];
				$year = $_POST['year'];
				$drMonth = $_POST['drMonth'];
				$drDay = $_POST['drDay'];
				$drYear = $_POST['drYear'];
				$dateReceived = $this->model->formatDate($drMonth,$drDay,$drYear);
				# additional info
				$edition = $_POST['edition'];
				$cost = $_POST['cost'];
				$source = $_POST['source'];
				$class = $_POST['class'];
				$qty = $_POST['qty'];
				$remarks = $_POST['remarks'];


				# insert data to database and get response message
				$response = $this->model->createBook(
					$bookNumber,$isbn,$title,$author,$publisher,
					$description,$pages,$year,$dateReceived,
					$edition,$cost,$source,$class,$qty,$remarks
				);

				$data['response'] = $response;
				
				$this->loadView('head',$data);
				$this->loadView('navbar',$data);
				$this->loadView('create_book_onsave',$data);	
				$this->loadView('footer',null);	
			}
		}
	}
?>