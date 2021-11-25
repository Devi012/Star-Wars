<?php
/*
Plugin Name: Star Wars
Description: Show information from Star Wars

*/

// Register and load the widget
function starwars() {
   register_widget( 'Star_Wars_widget' );
}
add_action( 'widgets_init', 'starwars' );



// The widget Class
class Star_Wars_widget extends WP_Widget
{

   public function __construct()
   {
      parent::__construct(

      // Base ID of your widget
         'Star_Wars_widget',

         // Widget name will appear in UI
         __('Star Wars Widget', 'Star_Wars_widget_domain'),

         // Widget description
         array('description' => __('Show Star Wars Details in a Widget', 'Star_Wars_widget_domain'),)
      );
   }

   // Updating widget - replacing old instances with new
   function update($new_instance, $old_instance)
   {
      $instance = array();
      $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
      return $instance;
   }

   // Creating widget front-end view
   function widget($args, $instance)
   {
      extract($args);
      $title = apply_filters('widget_title', $instance['title']);

      // before and after widget arguments are defined by themes
      echo $before_widget;
      if (!empty($title)) {
         echo $before_title . $title . $after_title;
      }

      // This is where you run the code and display the output
//    echo __('Hello World!', 'text_domain');
      // Star Wars API
      $request= wp_remote_get('https://swapi.dev/api/starships');
//    if(is_wp_error($request)){
//       return false;
//    }
      $body = wp_remote_retrieve_body($request);

      $data = json_decode($body);
      new stdClass();
      if(!empty($data->results)){
         echo '<ul>';
         foreach ($data->results as $r){
            echo '<li>';
            echo '<a href= "' . esc_url($r->name) . '">' . $r->name . '</a>';
            echo '</li>';
         }
         echo '</ul>';
      }

      echo $after_widget;
   }

   // Widget Backend - this controls what you see in the Widget UI
   
   function form($instance)
   {
      if (isset($instance['title'])) {
         $title = $instance['title'];
      } else {
         $title = __('New title', 'text_domain');
      }


      // Widget admin form
      ?>
      <p>
         <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
         <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
               name="<?php echo $this->get_field_name('title'); ?>" type="text"
               value="<?php echo esc_attr($title); ?>"/>
      </p>
      <?php
   }


} // Class Star_Wars_widget ends here