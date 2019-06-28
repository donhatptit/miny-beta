<?php
/**
 * Created by PhpStorm.
 * User: conghoan
 * Date: 6/28/18
 * Time: 10:48
 */

// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Trang chủ', route('frontend.home.index'));
});

// Home > [Category]
Breadcrumbs::register('category', function ($breadcrumbs, $category) {
    $breadcrumbs->parent('home');
    if(isset($category)){
        $breadcrumbs->push($category->name, route('frontend.category.index', $category->slug));
    }

});
Breadcrumbs::register('category-subject',function($breadcrumbs, $category){
    $category_parent = $category->parent()->select('name','slug')->first();
    if($category_parent){
        $breadcrumbs->parent('category',$category_parent);
    }else{
        $breadcrumbs->parent('home');
    }
    $breadcrumbs->push($category->name, route('frontend.category.index', $category->slug));
});
Breadcrumbs::register('category-lesson',function($breadcrumbs, $category, $category_subject = null){
    if(!empty($category_subject)){
        $breadcrumbs->parent('category-subject',$category_subject);
        $breadcrumbs->push($category->name, route('frontend.category.index', $category->slug));
    }else{
        $breadcrumbs->parent('home');
    }

});
// Home > [Category] > [Post]
Breadcrumbs::register('post', function ($breadcrumbs, $post, $category, $category_subject) {

    $breadcrumbs->parent('category-lesson',$category, $category_subject);
    $breadcrumbs->push($post->title, route('frontend.post.detail', $post->slug));
});
Breadcrumbs::register('search',function($breadcrumbs){
    $breadcrumbs->push('Tìm kiếm');
});
Breadcrumbs::register('result-search',function($breadcrumbs,$query){
    $breadcrumbs->parent('search');
    $breadcrumbs->push($query);
});
Breadcrumbs::register('question-flash',function($breadcrumbs,$category){
    $breadcrumbs->parent('home');
    $breadcrumbs->push($category->name,route('frontend.question',[$category->code,$category->slug]));
});
Breadcrumbs::register('question-flash-one',function($breadcrumbs,$query){
    $breadcrumbs->parent('question-flash',$query->parent()->select('name','slug','id','parent_id','code')->first());
    $breadcrumbs->push($query->name,route('frontend.question',[$query->code,$query->slug]));
});
Breadcrumbs::register('question-flash-two',function($breadcrumbs,$query){
    $breadcrumbs->parent('question-flash-one',$query->parent()->select('name','slug','id','parent_id', 'code')->first());
    $breadcrumbs->push($query->name);
});
Breadcrumbs::register('intro',function($breadcrumbs){
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Giới thiệu');
});


//$chemicalequation = (object) ['name'=> 'Phương trình hóa học','slug' => 'phuong-trinh-hoa-hoc'];
// Home > phuong trinh hoa hoc
Breadcrumbs::register('chemicalequation', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Phương trình hóa học', route('frontend.equation.index', 'phuong-trinh-hoa-hoc'));
});
// Home > phuong trinh hoa hoc > phan ung oxi hoa khu
Breadcrumbs::register('equation-cate', function ($breadcrumbs, $cate) {
    $breadcrumbs->parent('chemicalequation');
    $breadcrumbs->push($cate->name, route('frontend.equation.listEquationbyCate', $cate->slug));
});
// Home > phuong trinh hoa hoc > phan ung oxi hoa khu > CaCo3/CaO+CO2

Breadcrumbs::register('equation', function ($breadcrumbs, $one_equation) {
    $breadcrumbs->parent('equation-cate',$one_equation->equation_tags[0]);
    $breadcrumbs->push($one_equation->slug, route('frontend.equation.equationDetail', $one_equation->slug));
});
// Home > chat hoa hoc
Breadcrumbs::register('chemical', function ($breadcrumbs) {
    $breadcrumbs->parent('chemicalequation');
    $breadcrumbs->push('Chất hóa học', route('frontend.equation.chemical'));
});
// Home > chat hoa hoc > Ag
Breadcrumbs::register('chemicaldetail', function ($breadcrumbs, $symbol) {
    $breadcrumbs->parent('chemical');
    $breadcrumbs->push($symbol, route('frontend.equation.chemical'));
});
// Home > Bang tinh tan
Breadcrumbs::register('bangtinhtan', function ($breadcrumbs, $chemical) {
    $breadcrumbs->parent('chemicalequation');
    $breadcrumbs->push('Bảng tính tan', route('frontend.equation.dissolubilityTable'));
});
Breadcrumbs::register('bangtuanhoan', function ($breadcrumbs, $chemical) {
    $breadcrumbs->parent('chemicalequation');
    $breadcrumbs->push('Bảng tuần hoàn hóa học', route('frontend.equation.periodicTable'));
});
Breadcrumbs::register('daydienhoa', function ($breadcrumbs, $chemical) {
    $breadcrumbs->parent('chemicalequation');
    $breadcrumbs->push('Dãy điện hóa', route('frontend.equation.electrochemicalTable'));
});
Breadcrumbs::register('dayhoatdongkimloai', function ($breadcrumbs, $chemical) {
    $breadcrumbs->parent('chemicalequation');
    $breadcrumbs->push('Dãy hoạt động kim loại', route('frontend.equation.reactivityseriesTable'));
});

// Home > Tuyen Sinh
//Breadcrumbs::register('tuyen-sinh', function ($breadcumbs){
//    $breadcrumbs->parent('home');
//    $breadcrumbs->push('Tuyển sinh');
//});
Breadcrumbs::register('tuyen-sinh', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Tuyển sinh', route('admission.home'));
});
Breadcrumbs::register('thong-tin-truong', function ($breadcrumbs, $university, $type){
    $breadcrumbs->parent('tuyen-sinh');
    $breadcrumbs->push($type .' - ' . $university->vi_name);
});
Breadcrumbs::register('danh-sach-truong', function ($breadcrumbs) {
    $breadcrumbs->parent('tuyen-sinh');
    $breadcrumbs->push('Thông tin trường');
});
Breadcrumbs::register('tra-cuu-diem-chuan', function ($breadcrumbs) {
    $breadcrumbs->parent('tuyen-sinh');
    $breadcrumbs->push('Tra cứu điểm chuẩn');
});
Breadcrumbs::register('tin-tuyen-sinh', function ($breadcrumbs) {
    $breadcrumbs->parent('tuyen-sinh');
    $breadcrumbs->push('Tin tuyển sinh', route('admission.university.news'));
});
Breadcrumbs::register('tu-van-tuyen-sinh', function ($breadcrumbs) {
    $breadcrumbs->parent('tuyen-sinh');
    $breadcrumbs->push('Tư vấn tuyển sinh', route('admission.university.advice'));
});
Breadcrumbs::register('nganh-hoc', function ($breadcrumbs, $topic) {
    $breadcrumbs->parent('tu-van-tuyen-sinh');
    $breadcrumbs->push($topic->name);
});
Breadcrumbs::register('bai-viet', function ($breadcrumbs, $post) {
    if(!empty($post->university_id)){
        $breadcrumbs->parent('tin-tuyen-sinh');
    }else{
        $breadcrumbs->parent('tu-van-tuyen-sinh');
    }
    $breadcrumbs->push($post->title);
});
