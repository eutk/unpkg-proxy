# pathHandler

无伪静态路径解决方案

## 示例

| 路径                                | \pathHandler\get(0) | \pathHandler\get(1) |
| ----------------------------------- | ------------------- | ------------------- |
| /[index.php]?/path/to/file [^1]     | /path/to/file       | /path/to/file       |
| /[index.php]?/path/to/file?q=a      | /path/to/file       | /path/to/file?q=a   |
| /[index.php]?/path/to/file?q=a [^2] | /path/to/file       | /path/to/file&q=a   |
| /index.php/path/to/file             | /path/to/file       | /path/to/file       |
| /index.php/path/to/file?q=a         | /path/to/file       | /path/to/file?q=a   |

[^1]:
    /[index.php]?/path/to/file 表示 /?/path/to/file 或 /index.php?/path/to/file  
    其中，index.php 也可以是其它脚本。

[^2]:
    调用 \pathHandler\redirect() 函数后 /?/path/to/file?q=a 才会跳转至 /?/path/to/file&q=a  
    这样方能获取到$\_GET['q']
    请注意 \pathHandler\get(1) 的区别。

如需要伪静态，请这样设置：

```
// Apache
RewriteRule ^(.*) index.php/$1 [L]
// Nginx
rewrite  ^(.*)$  /index.php/$1
// index.php可以是其它脚本
```

```php
require_once("./lib/pathHandler/main.php");  // 引入库文件
\pathHandler\redirect();  // 处理$_GET失效问题,需要$_GET时使用
// 函数只需要调用一次！
$path0 = \pathHandler\get(0);    // 不含querystring
$path1 = \pathHandler\get(1);    // 包括querystring
```
