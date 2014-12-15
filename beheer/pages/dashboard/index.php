<h1>Welkom <?php echo user_data('name').' '.user_data('surname');?></h1>

<?php
$id = user_data('id');

function showProjects($uid){
    global $mysqli;
    $query = $mysqli->query('SELECT * FROM project WHERE uid = '.$uid.' ORDER BY created');
    if($mysqli->error) return 404;
    if($query ->num_rows == 0){
        echo "<div class='alert-error'> U bent op dit moment nog niet gekoppeld aan een project</div>";
        return;
    }
    echo '<tr><th>Project Naam</th><th>Aanmaakdatum</th><th>Items</th></tr>';
    while($row = $query->fetch_array()){
        echo '<tr>';
        echo '<td>'.$row['title'].'</td>';
        echo '<td>'.$row['created'].'</td>';
        echo "<td> <a href='/beheer/customers/projectsView/". $row['id']."'>Foto's</a></td>";
        echo '</tr>';
    }
}
?>
<table>

    <?php showProjects($id)?>
</table>


<script>
(function(w,d,s,g,js,fs){
g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
js.src='https://apis.google.com/js/platform.js';
fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));
</script>



<div id="embed-api-auth-container"></div>
<div id="chart-container"></div>
<div id="view-selector-container"></div>

<script>

    gapi.analytics.ready(function() {

        /**
         * Authorize the user immediately if the user has already granted access.
         * If no access has been created, render an authorize button inside the
         * element with the ID "embed-api-auth-container".
         */
        gapi.analytics.auth.authorize({
            container: 'embed-api-auth-container',
            clientid: '1028830573230-ita0jk23am95t537433oqprj56t153fl.apps.googleusercontent.com',
        });


        /**
         * Create a new ViewSelector instance to be rendered inside of an
         * element with the id "view-selector-container".
         */
        var viewSelector = new gapi.analytics.ViewSelector({
            container: 'view-selector-container'
        });

        // Render the view selector to the page.
        viewSelector.execute();


        /**
         * Create a new DataChart instance with the given query parameters
         * and Google chart options. It will be rendered inside an element
         * with the id "chart-container".
         */
        var dataChart = new gapi.analytics.googleCharts.DataChart({
            query: {
                metrics: 'ga:sessions',
                dimensions: 'ga:date',
                'start-date': '30daysAgo',
                'end-date': 'yesterday'
            },
            chart: {
                container: 'chart-container',
                type: 'LINE',
                options: {
                    width: '100%'
                }
            }
        });


        /**
         * Render the dataChart on the page whenever a new view is selected.
         */
        viewSelector.on('change', function(ids) {
            dataChart.set({query: {ids: ids}}).execute();
        });

    });
</script>