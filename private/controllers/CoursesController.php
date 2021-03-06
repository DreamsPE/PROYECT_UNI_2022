<?php
class CoursesController extends Controller
{
    
	public function index()
	{
		// code...
		//if(!Auth::logged_in())
		//{
			//$this->redirect('login');
		//}
		

		//if (!Auth::logged_in()) {
        //    $this->redirect('login');
        //}

        $course =  new Course();

        $data = $course->findAll();

        $crumbs[] = ['Principal', ''];
        $crumbs[] = ['Asignaturas', 'courses'];

        $this->view('courses\index', [
            'rows' => $data,
            'crumbs' => $crumbs
        ]);


	}

	public function create()
    {

//
        //if (!Auth::logged_in()) {
        //    $this->redirect('login');
        //}
        $query = "select * from grado";
        $course =  new Course();
        $data = $course->query($query);

        $errors =  array();
        $crumbs[] = ['Principal', ''];
        $crumbs[] = ['Asignaturas', 'courses'];
        $crumbs[] = ['Nuevo', 'courses/create'];

        //if (Auth::access('super_admin')) {
            $this->view('courses\create', [
                'crumbs' => $crumbs,
                'errors' => $errors,
                'rows' => $data
            ]);
        //} else {
        //    $this->view('access-denied');
        //}
    }

    public function store()
    {
        //if (!Auth::logged_in()) {
        //    $this->redirect('login');
        //}

        $errors = array();
        //if (count($_POST) > 0 && Auth::access('super_admin')) {
            $curso = new Course();

            if ($curso->validate($_POST)) {
                $curso->insert($_POST);
                
                $this->redirect('courses');
            } else {
                $errors = $curso->errors;
            }
        //}

        $query = "select * from grado";
        $course =  new Course();
        $data = $course->query($query);

        $crumbs[] = ['Principal', ''];
        $crumbs[] = ['Asignaturas', 'courses'];
        $crumbs[] = ['Nuevo', 'courses/create'];

        $this->view('courses\create', [
            'crumbs' => $crumbs,
            'errors' => $errors,
            'rows' => $data
        ]);
    }

    public function destroy($id=null)
    {   
		// code...
		//if(!Auth::logged_in())
		//{
		//	$this->redirect('login');
		//}
       
		$course = new Course();
		$errors = array();

		if(count($_POST) > 0 /*&& Auth::access('super_admin')*/)
 		{
            $course->delete('Id_Curso', $id);
 			$this->redirect('courses');
  		}

 		$row = $course->where('Id_Curso',$id);
 		$crumbs[] = ['Principal',''];
		$crumbs[] = ['Asignaturas','courses'];
		$crumbs[] = ['Eliminar','courses'];

		//if(Auth::access('super_admin')){
			$this->view('courses\delete',[
				'row'=>$row,
	 			'crumbs'=>$crumbs,
			]);
		//}else{
		//	$this->view('access-denied');
		//}
	}

    public function edit($id = null)
    {
        //if (!Auth::logged_in()) {
        //    $this->redirect('login');
        //}

        $course = new Course();
        $data = $course->findById('Id_Curso', $id);


        $query = "select * from grado";
        $courses = $course->query($query);

        $errors =  array();
        $crumbs[] = ['Dashboard', ''];
        $crumbs[] = ['Asignaturas', 'courses'];
        $crumbs[] = ['Modificar', 'courses'];

        //if (Auth::access('super_admin')) {
            $this->view('courses\edit', [
                'rows' => $data,
                'courses' => $courses,
                'crumbs' => $crumbs,
                'errors' => $errors,
            ]);
        //} else {
        //    $this->view('access-denied');
        //}
    }

    public function update($id = null)
    {
        //if (!Auth::logged_in()) {
        //    $this->redirect('login');
        //}

        $errors = array();
        if (count($_POST) > 0 /*&& Auth::access('super_admin')*/) {
            $course = new Course();
            if ($course->validate($_POST)) {
                $course->update('Id_Curso',$id, $_POST);

                //if (isset($_POST['persona_id']) && is_numeric($_POST['persona_id'])) {
                //    $propietario['inmueble_id'] =  $id;
                //    $propietario['persona_id'] =  $_POST['persona_id'];
                //
                //    if (!$inmueble->upd_propietario($propietario)) {
                //        $inmueble->set_propietario($propietario);
                //    }
                //}
                $this->redirect('courses');
            } else {
                $errors = $course->errors;
            }
        }

        $this->redirect('courses');
    }

}