<?php
	define('ROOT_DIR', dirname(dirname(__FILE__)));
	require_once(ROOT_DIR.'/htdocs/function.php');
	require_once(ROOT_DIR.'/htdocs/header.php');
?>

<?php
	if(!isLoggedIn() || userIdentity() != 'general'){
		redirectTo('signIn.php');
	}
	if(isset($_GET['delete']) && filter_input(INPUT_POST, 'del_token', FILTER_SANITIZE_STRING) == $_SESSION['del_token']){
		if(postById($_GET['delete'])['author_account'] == userAccount()){
			deletePost($_GET['delete']);
		}
		redirectTo('bulletin.php');
	}
	else if(isset($_GET['id'])){		
		$post = postById($_GET['id']);
		$attachedFile = $post['attached_file']?'<a href="'.$post['attached_file'].'" download> attached file </a>':'';
		echo '<div class="card"><div class="incard">
			<h4>' . replaceBBcodes($post['content']) .'</h4>' . $attachedFile . 
			'<h5>created by ' . $post['author_account'] . '</h5>
			<h5>at ' . $post['time'] . '</h5></div></div>';
	}
	else{
		$_SESSION['del_token'] = md5(uniqid(mt_rand(), true));
		echo '<div class="board"><form action="newPost.php" method="post">
				<button class="new-btn" type="submit">New post</button>
			</form>';
		$posts = allPost();
		for ($i=0; $i<count($posts); $i++) {
			$attachedFile = $posts[$i]['attached_file']?'<a href="'.$posts[$i]['attached_file'].'" download> attached file </a>':'';
			echo '<div class="card"><div class="incard">
				<h4>' . replaceBBcodes($posts[$i]['content']) .'</h4>' . $attachedFile . 
				'<h5>created by ' . $posts[$i]['author_account'] . '</h5>
				<h5>at ' . $posts[$i]['time'] . '</h5>';
			echo '<div class="center"><form style="display:inline-block" action="bulletin.php?id=' . $posts[$i]['id'] . '" method="post">
					<button type="submit" role="button" name="show">show</button>
				</form>';
			if($posts[$i]['author_account'] == userAccount()){
				echo '<form style="display:inline-block" action="bulletin.php?delete=' . $posts[$i]['id'] . '" method="post">
					<input type="hidden" name="del_token" value="'.$_SESSION["del_token"].'">
					<button type="submit" role="button" name="delete">delete</button>
					</form></div>';
			}
			else{
				echo '<form style="display:inline-block"><button disabled>delete</button></form></div>';
			}
			echo '</div></div>';
			//echo replaceBBcodes($posts[$i]['content']) . "  " . $posts[$i]['time'] . "  " . $posts[$i]['author_account'] . "  </br>";*/
		}
		echo '</div>';
	}	
?>

