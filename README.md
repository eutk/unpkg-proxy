# UNPKG PROXY

伪静态是可选的，若启用，必须将index.php置于根目录  

否则在apache环境下请将.htaccess删除  

若不启用伪静态，可将index.php以任意文件名置于任意目录  

unpkg.html为默认首页，置于index.php相同目录  

若删除，将获取unpkg.com首页  

另，对于example.net/?pakage 会跳转至 example.net/index.php/package  