<?php
minRole(3);
?>
<a href="/beheer/portfolio/add" class="button blue">Album toevoegen</a>
<h1>Portfolio albums</h1>
<?php
$result = $mysqli->query("SELECT * FROM portfolio ORDER BY id DESC");
if($result->num_rows > 0){
?>
<table>
    <tr>
        <th>Portfolio album</th><th width="75">Acties</th>
    </tr>

    <?php
    while($portfolio = $result->fetch_object()){
        ?>
        <tr>
            <td><a href="/beheer/portfolio/view/<?php echo $portfolio->id;?>"><?php echo $portfolio->name;?></a></td>
            <td>
                <a href="/beheer/portfolio/edit/<?php echo $portfolio->id; ?>"><img src="/beheer/res/img/pencil90.png" alt="edit"/></a> |
                <a href="/beheer/portfolio/delete/<?php echo $portfolio->id; ?>"><img src="/beheer/res/img/black393.png" alt="edit" onclick="return confirm('Weet je zeker dat je dit portfolio wilt verwijderen')"/></a> |
                <a href="/beheer/portfolio/addPhoto/<?php echo $portfolio->id;?>"><img src="/beheer/res/img/plus24.png" alt="add"/></a>
            </td>
        </tr>
    <?php
    }
    }else{
        echo '<div class="alert-error">Er zijn momenteel geen portfolio albums.</div>';
    }
    ?>

</table>
