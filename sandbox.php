<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/app/include/function.php');
$tapinambur=new tapinambur();
$tapinamburAPI=new tapinamburAPI();
$article=$tapinambur->getArticle($_GET["id"]);
if ($article) {
    $tapinamburAPI->openSandbox($article["id"]);
    $article["full_content"]=preg_replace('/\s+/', ' ', $article["full_content"]);
    $title=$article["header"].' | tapinambur API';
    $style_less=array("news-style.less");
    include_once($_SERVER['DOCUMENT_ROOT'].'/app/header.php');
} else {
    exit(header("Location: /404/"));
}
?>
<div id="myContainer">
<h1>Header</h1>
<input class="form-control" name="original-header" value="<?=$article['header']; ?>" readonly>
<input class="form-control" name="header">
<?php if ($article['content']): ?>
<h1>Content</h1>
<textarea name="original-content" class="form-control" rows="2" readonly><?=$article['content']; ?></textarea>
<textarea name="content" class="form-control" rows="2"></textarea>
<?php endif; ?>
<h1>Full content</h1>
<div class="row">
<div class="col-md-6 col-xs-12">
<div name="original-full-content" class="form-control" readonly><?=$article['full_content']; ?></div>
</div>
<div class="col-md-6 col-xs-12">
<div name="full-content" class="form-control" contenteditable></div>
</div>
</div>
<button name="save" class="btn btn-success btn-block" data-id="<?=$article['id']; ?>">Save</button>
</div>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/app/footer.php'); ?>
<script>
    window.addEventListener('beforeunload', function(e) {
        $.ajax({
            url: "/public/php/close-sandbox.php",
            type: "POST",
            async: false,
            data: {"article_id" : <?php echo($_GET["id"]); ?>}
        });

        let dialogText = 'Take care now, bye-bye then.';
        e.returnValue = dialogText;

        return dialogText;
    }, false);

    $(document).ready(function() {
        translate();

        $("button[name='save']").click(function() {
            let articleId = $(this).attr("data-id");
            let originalHeader = $("input[name='original-header']").val();
            let header = $("input[name='header']").val();
            let originContent = '';
            let content = '';

            if ($("textarea").is("[name='original-content']") && $("textarea").is("[name='content']")) {
                originContent = $("textarea[name='original-content']").val();
                content = $("textarea[name='content']").val();
            }

            let originalFullContent = $("div[name='original-full-content']").html();
            let fullContent = $("div[name='full-content']").html();

            if (articleId && checkContent(originalHeader, header, 5) && checkContent(originContent, content, 10) && checkContent(originalFullContent, fullContent, 200) && articleId) {
                $.ajax({
                    url: '/public/php/set-translate-article.php',
                    type: 'POST',
                    data: {header, content, full_content : fullContent, article_id : articleId},
                    success: function(data) {
                        if (data == 0) {
                            let article = {
                                "article_id" : articleId,
                                "header" : header,
                                "content" : content,
                                "full_content" : fullContent
                            }

                            localStorage.setItem(`translate-save-article-${articleId}`, JSON.stringify(article));
                            location.reload();
                        }

                        alert("Дякуємо за Ваш переклад");
                    }
                });
            } else {
                if (checkContent(originalHeader, header, 5)) {
                    $("input[name='header']").css("border","1px solid #ccc");
                } else {
                    $("input[name='header']").css("border","1px solid #ff0000");
                }

                if (checkContent(originContent, content, 10)) {
                    $("textarea[name='content']").css("border","1px solid #ccc");
                } else {
                    $("textarea[name='content']").css("border","1px solid #ff0000");
                }

                if (checkContent(originalFullContent, fullContent, 250)) {
                    $("textarea[name='full-content']").css("border","1px solid #ccc");
                } else {
                    $("textarea[name='full-content']").css("border","1px solid #ff0000");
                }

                if (!articleId) {
                    $("button[name='save']").attr("data-id","<?php echo($_GET['id']); ?>)");
                    $("button[name='save']").trigger("click");
                }
            }
        });
    });

    function translate() {
        let header = $("input[name='original-header']").val();
        let content = '';

        if ($("textarea").is("[name='original-content']")) {
            content = $("textarea[name='original-content']").val();
        }

        let fullContent = $("div[name='original-full-content']").html();

        $.ajax({
            url: '/MicrosoftTranslate.php',
            type: "POST",
            data: {text : header},
            success: function(data) {
                $("input[name='header']").val(data);
            }
        });

        if (content) {
            $.ajax({
                url: '/MicrosoftTranslate.php',
                type: "POST",
                data: {text : content},
                success: function(data) {
                    $("textarea[name='content']").val(data);
                }
            });
        }

        $.ajax({
            url: '/MicrosoftTranslate.php',
            type: "POST",
            data: {text : fullContent},
            success: function(data) {
                $("div[name='full-content']").html(data);
            }
        });
    }
</script>
