<?php

session_start();

class Controller_Editbanner extends Controller
{

	function __construct()
	{
		$this->model = new Model_Editbanner();
		$this->view = new View();
	}


	function action_index()
	{			
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			$name = htmlspecialchars($_POST['name']);
			$status = htmlspecialchars($_POST['Status']);
			$id = htmlspecialchars($_POST['id']);
			$previous_URL = $this->model->db_select_URL($id);
			$extension_on_1 = explode(".", $previous_URL);
			$URL = "assets/images/".$name.".".$extension_on_1[1];

			if ($this->model->db_update_banner($name, $URL, $status, $id) === TRUE) {

				echo "Update successfully";
			}
			else {

				echo "Update failed";
				exit();
			}

			clearstatcache();

			if (file_exists($previous_URL) && is_file($previous_URL)) {

				if (rename($previous_URL, $URL)) {

					echo "File renamed";
				} 
				else {

					echo "Failed to rename file";
					exit();
				}
			} 
			else {

				echo "File does not exist";
				exit();
			}		
			
			header('Location:/banner');
		}
		
		$this->view->generate('editbanner_view.php', 'template_view.php');
	}
}
