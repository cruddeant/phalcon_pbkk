<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
    }

    public function show404Action()
    {
    }

    public function show503Action()
    {
    }

    public function Searchaction(Request $request){ 
            if($request->ajax()){ 
                $output = ''; 
                $query = $request->get('query'); 
                if($query != ''){ 
                        $data = Articles::orderBy('id', 'desc')
                        ->where('id', 'like', '%'.$query.'%')
                        ->orWhere('title', 'like', '%'.$query.'%')
                        ->orWhere('description', 'like', '%'.$query.'%')
                        ->orWhere('created', 'like', '%'.$query.'%')
                        ->get(); 

                } 
                else {
                  $data = DB::table('Articles')->orderBy('id', 'asc')->paginate(2); 
                } 

                $total_row = $data->count(); 
                    if($total_row > 0){ 
                        foreach($data as $row){
                            $idedit = $row->id;                         
                            $output .= ' <tr>
                                            <td>'.$row->id.'</td>
                                            <td>'.$row->title.'</td>
                                            <td>'.$row->description.'</td>
                                            <td>'.$row->created.'</td>
                                        </tr>';
                        } 
                    } 
                    else{ 
                        $output = 'No Data Found';
                    } 
                    $data = array( 'table_data' => $output, 'total_data' => $total_row ); 
                    echo json_encode($data); 
            } 
    }
}

