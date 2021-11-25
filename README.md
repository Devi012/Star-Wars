1. Firstly we create the plugin
2. We register and load the widget.
3. We create the widget class by calling a public function for each new child created
4. We create a function to update the widget if any information is added in the future.
5. We create the widget front-end view	
6. We make a request to get the API from starships and turn false if there is an error in the request.
7. We decode the body through the JSON format to convert the objects.
8. We call a function form($instance) to get a new title to control what we see in the widget user interface.
9. We create the widget admin form.	
