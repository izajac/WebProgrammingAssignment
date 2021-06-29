
<?php
//SOURCE: Joke site from Topic 13
function loadTemplate($fileName, $templateVars) {
	   extract($templateVars);
        ob_start();
        require $fileName;
        $contents = ob_get_clean();
        return $contents;       
}

?>
