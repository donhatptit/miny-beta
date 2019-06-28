@extends('frontend.layouts.master_equation')
@section('css')
    <style>
        {!! file_get_contents(public_path("frontend/css/periodic_table_tool.css")) !!}
    </style>
@endsection
@section('content')
    <div class="equation-heading">
        <div class="container text-center">
            <div class="menu">
                <i class="fas fa-caret-left arrow-left d-sm-none d-xs-inline-block"></i>
                <div class="wrap-menu">
                    <button class="category btn py-2"><i class="fas fa-bong"></i> Chủ đề</button>
                    <button class="tool btn py-2 active"><i class="fas fa-vials"></i> Công cụ hóa học</button>
                    <a href="{{route('frontend.equation.chemical',[],false)}}"><button class="chemical btn py-2"><i class="fas fa-magic"></i>Chất hóa học </button></a>
                </div>
                <i class="fas fa-caret-right arrow-right d-sm-none d-xs-inline-block"></i>
                <div class="list-category d-none" id="list-category">
                    <div class="wrapper">
                        <table class="container-fluid" style="border: none">
                            @foreach (array_chunk($category->toArray(), 4, true) as $array)
                                <tr class="row">
                                    @foreach($array as $one_cate)
                                        <td class="col-sm-3"><a href="{{route('frontend.equation.listEquationbyCate', ['slug'=> $one_cate['slug']], false)}}">{{ $one_cate['name'] }}</a></td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="list-category d-none" id="list-tool">
                    <div class="wrapper">
                        <table class="container-fluid text-center" style="border: none;">
                            <tbody>
                            <tr class="row">
                                <td class="col-sm-3"><a href="{{route('frontend.equation.electrochemicalTable',[],false)}}">Dãy điện hóa</a></td>
                                <td class="col-sm-3"><a href="{{route('frontend.equation.reactivityseriesTable',[],false)}}">Dãy hoạt động của kim loại</a></td>
                                <td class="col-sm-3"><a href="{{route('frontend.equation.dissolubilityTable',[],false)}}">Bảng tính tan</a></td>
                                <td class="col-sm-3"><a href="{{route('frontend.equation.periodicTable',[],false)}}">Bảng tuần hoàn</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="pb-md-3"></div>
        </div>
    </div>

    <section class="container tool-periodic">
        <p class="text-center title my-3"> Bảng tuần hoàn các nguyên tố hóa học đầy đủ nhất</p>
        <div class="card px-sm-3 py-sm-3">
            <div class="card-block">
                <div class="table-responsive">
                    <table class="periodic-table ">
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <tr class="text-center table-header">
                            <th style="width: 65px;">
                                <div style="float: left;width: 100%;">Nhóm →</div>
                                <div>↓ Chu kỳ</div>
                            </th>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                            <th>7</th>
                            <th>8</th>
                            <th>9</th>
                            <th>10</th>
                            <th>11</th>
                            <th>12</th>
                            <th>13</th>
                            <th>14</th>
                            <th>15</th>
                            <th>16</th>
                            <th>17</th>
                            <th>18</th>
                        </tr>
                        <tr>
                            <th class="text-center">1</th>
                            <td class="non-metal nature gas chemical" data-html="true" title="Hidro">
                                <div class="symbol">H</div>
                                <div class="number">1</div>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="nature gas rare-gas chemical" data-html="true" title="Heli">
                                <div class="symbol">He</div>
                                <div class="number">2</div>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center">2</th>
                            <td class="weak-metal solid nature chemical" data-html="true" title="Liti">
                                <div class="symbol">Li</div>
                                <div class="number">3</div>
                            </td>
                            <td class="alkaline-earth-metal nature solid chemical" data-html="true" title="Berili">
                                <div class="symbol">Be</div>
                                <div class="number">4</div>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="half-metal solid nature chemical" data-html="true" title="Bo">
                                <div class="symbol">B</div>
                                <div class="number">5</div>
                            </td>
                            <td class="non-metal solid nature chemical" data-html="true" title="Cacbon">
                                <div class="symbol">C</div>
                                <div class="number">6</div>
                            </td>
                            <td class="non-metal solid nature chemical" data-html="true" title="Nitơ">
                                <div class="symbol">N</div>
                                <div class="number">7</div>
                            </td>
                            <td class="non-metal solid nature chemical" data-html="true" title="Ôxy">
                                <div class="symbol">O</div>
                                <div class="number">8</div>
                            </td>
                            <td class="halogen gas nature chemical" data-html="true" title="Flo">
                                <div class="symbol">F</div>
                                <div class="number">9</div>
                            </td>
                            <td class="rare-gas gas nature chemical" data-html="true" title="Neon">
                                <div class="symbol">Ne</div>
                                <div class="number">10</div>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center">3</th>
                            <td class="alkali-metal solid nature chemical" data-html="true" title="Natri">
                                <div class="symbol">Na</div>
                                <div class="number">11</div>
                            </td>
                            <td class="alkaline-earth-metal nature solid chemical" data-html="true" title="Magiê">
                                <div class="symbol">Mg</div>
                                <div class="number">12</div>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="weak-metal solid nature chemical" data-html="true" title="Nhôm">
                                <div class="symbol">Al</div>
                                <div class="number">13</div>
                            </td>
                            <td class="half-metal solid nature chemical" data-html="true" title="Silic">
                                <div class="symbol">Si</div>
                                <div class="number">14</div>
                            </td>
                            <td class="non-metal solid nature chemical" data-html="true" title="Phốtpho">
                                <div class="symbol">P</div>
                                <div class="number">15</div>
                            </td>
                            <td class="non-metal solid nature chemical" data-html="true" title="Lưu huỳnh">
                                <div class="symbol">S</div>
                                <div class="number">16</div>
                            </td>
                            <td class="halogen gas nature chemical" data-html="true" title="Clo">
                                <div class="symbol">Cl</div>
                                <div class="number">17</div>
                            </td>
                            <td class="rare-gas gas nature chemical" data-html="true" title="Agon">
                                <div class="symbol">Ar</div>
                                <div class="number">18</div>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center">3</th>
                            <td class="alkali-metal solid nature chemical" data-html="true" title="Kali">
                                <div class="symbol">K</div>
                                <div class="number">19</div>
                            </td>
                            <td class="alkaline-earth-metal nature solid chemical" data-html="true" title="Canxi">
                                <div class="symbol">Ca</div>
                                <div class="number">20</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Scandi">
                                <div class="symbol">Sc</div>
                                <div class="number">21</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Titani">
                                <div class="symbol">Ti</div>
                                <div class="number">22</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Vanadi">
                                <div class="symbol">V</div>
                                <div class="number">23</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Crom">
                                <div class="symbol">Cr</div>
                                <div class="number">24</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Mangan">
                                <div class="symbol">Mn</div>
                                <div class="number">25</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Sắt">
                                <div class="symbol">Fe</div>
                                <div class="number">26</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Coban">
                                <div class="symbol">Co</div>
                                <div class="number">27</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Niken">
                                <div class="symbol">Ni</div>
                                <div class="number">28</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Đồng">
                                <div class="symbol">Cu</div>
                                <div class="number">29</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Kẽm">
                                <div class="symbol">Zn</div>
                                <div class="number">30</div>
                            </td>
                            <td class="weak-metal solid nature chemical" data-html="true" title="Gali">
                                <div class="symbol">Ga</div>
                                <div class="number">31</div>
                            </td>
                            <td class="half-metal solid nature chemical" data-html="true" title="Gecmani">
                                <div class="symbol">Ge</div>
                                <div class="number">32</div>
                            </td>
                            <td class="half-metal solid nature chemical" data-html="true" title="Asen">
                                <div class="symbol">As</div>
                                <div class="number">33</div>
                            </td>
                            <td class="non-metal solid nature chemical" data-html="true" title="Selen">
                                <div class="symbol">Se</div>
                                <div class="number">34</div>
                            </td>
                            <td class="halogen gas nature chemical" data-html="true" title="Brôm">
                                <div class="symbol">Br</div>
                                <div class="number">35</div>
                            </td>
                            <td class="rare-gas gas nature chemical" data-html="true" title="Krypton">
                                <div class="symbol">Kr</div>
                                <div class="number">36</div>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center">5</th>
                            <td class="alkali-metal solid nature chemical" data-html="true" title="Rubiđi">
                                <div class="symbol">Rb</div>
                                <div class="number">37</div>
                            </td>
                            <td class="alkaline-earth-metal nature solid chemical" data-html="true" title="Stronti">
                                <div class="symbol">Sr</div>
                                <div class="number">38</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Yttri">
                                <div class="symbol">Y</div>
                                <div class="number">39</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Zirconi">
                                <div class="symbol">Zr</div>
                                <div class="number">40</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Niobi">
                                <div class="symbol">Nb</div>
                                <div class="number">41</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Molypden">
                                <div class="symbol">Mo</div>
                                <div class="number">42</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Tecneti">
                                <div class="symbol">Tc</div>
                                <div class="number">43</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Rutheni">
                                <div class="symbol">Ru</div>
                                <div class="number">44</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Rhodi">
                                <div class="symbol">Rh</div>
                                <div class="number">45</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Paladi">
                                <div class="symbol">Pd</div>
                                <div class="number">46</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Bạc">
                                <div class="symbol">Ag</div>
                                <div class="number">47</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Cadmi">
                                <div class="symbol">Cd</div>
                                <div class="number">48</div>
                            </td>
                            <td class="weak-metal solid nature chemical" data-html="true" title="Indi">
                                <div class="symbol">In</div>
                                <div class="number">49</div>
                            </td>
                            <td class="weak-metal solid nature chemical" data-html="true" title="Thiếc">
                                <div class="symbol">Sn</div>
                                <div class="number">50</div>
                            </td>
                            <td class="half-metal solid nature chemical" data-html="true" title="Antimon">
                                <div class="symbol">Sb</div>
                                <div class="number">51</div>
                            </td>
                            <td class="half-metal solid nature chemical" data-html="true" title="Telua">
                                <div class="symbol">Te</div>
                                <div class="number">52</div>
                            </td>
                            <td class="halogen gas nature chemical" data-html="true" title="Iốt">
                                <div class="symbol">I</div>
                                <div class="number">53</div>
                            </td>
                            <td class="rare-gas gas nature chemical" data-html="true" title="Xenon">
                                <div class="symbol">Xe</div>
                                <div class="number">54</div>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center">6</th>
                            <td class="alkali-metal solid nature chemical" data-html="true" title="Xêzi">
                                <div class="symbol">Cs</div>
                                <div class="number">55</div>
                            </td>
                            <td class="alkaline-earth-metal nature solid chemical" data-html="true" title="Bari">
                                <div class="symbol">Ba</div>
                                <div class="number">56</div>
                            </td>
                            <td class="lantan ">
                                <div class="symbol">*</div>
                                <div class="number"></div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Axit flohydric">
                                <div class="symbol">Hf</div>
                                <div class="number">72</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Tantali">
                                <div class="symbol">Ta</div>
                                <div class="number">73</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Volfram">
                                <div class="symbol">W</div>
                                <div class="number">74</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Rheni">
                                <div class="symbol">Re</div>
                                <div class="number">75</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Osmi">
                                <div class="symbol">Os</div>
                                <div class="number">76</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Iridi">
                                <div class="symbol">Ir</div>
                                <div class="number">77</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Platin">
                                <div class="symbol">Pt</div>
                                <div class="number">78</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Vàng">
                                <div class="symbol">Au</div>
                                <div class="number">79</div>
                            </td>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Thủy ngân">
                                <div class="symbol">Hg</div>
                                <div class="number">80</div>
                            </td>
                            <td class="weak-metal solid nature chemical" data-html="true" title="Tali">
                                <div class="symbol">Tl</div>
                                <div class="number">81</div>
                            </td>
                            <td class="weak-metal solid nature chemical" data-html="true" title="Chì">
                                <div class="symbol">Pb</div>
                                <div class="number">82</div>
                            </td>
                            <td class="weak-metal solid nature chemical" data-html="true" title="Bitmut">
                                <div class="symbol">Bi</div>
                                <div class="number">83</div>
                            </td>
                            <td class="half-metal solid born-late chemical" data-html="true" title="Poloni">
                                <div class="symbol">Po</div>
                                <div class="number">84</div>
                            </td>
                            <td class="halogen gas born-late chemical" data-html="true" title="Astatin">
                                <div class="symbol">At</div>
                                <div class="number">85</div>
                            </td>
                            <td class="rare-gas gas born-late chemical" data-html="true" title="Radon">
                                <div class="symbol">Rn</div>
                                <div class="number">86</div>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center">7</th>
                            <td class="alkali-metal solid nature chemical" data-html="true" title="Rutherfordi">
                                <div class="symbol">Rf</div>
                                <div class="number">87</div>
                            </td>
                            <td class="alkaline-earth-metal born-late solid chemical" data-html="true" title="Radi">
                                <div class="symbol">Ra</div>
                                <div class="number">88</div>
                            </td>
                            <td class="actini ">
                                <div class="symbol">**</div>
                                <div class="number"></div>
                            </td>
                            <td class="transition-metal solid man-made chemical" data-html="true" title="Franxi">
                                <div class="symbol">Fr</div>
                                <div class="number">104</div>
                            </td>
                            <td class="transition-metal solid man-made chemical" data-html="true" title="Dubni">
                                <div class="symbol">Db</div>
                                <div class="number">105</div>
                            </td>
                            <td class="transition-metal solid man-made chemical" data-html="true" title="Seaborgi">
                                <div class="symbol">Sg</div>
                                <div class="number">106</div>
                            </td>
                            <td class="transition-metal solid man-made chemical" data-html="true" title="Bohr">
                                <div class="symbol">Bh</div>
                                <div class="number">107</div>
                            </td>
                            <td class="transition-metal solid man-made chemical" data-html="true" title="Hassi">
                                <div class="symbol">Hs</div>
                                <div class="number">108</div>
                            </td>
                            <td class="unknow-property solid man-made chemical" data-html="true" title="Meitneri">
                                <div class="symbol">Mt</div>
                                <div class="number">109</div>
                            </td>
                            <td class="unknow-property solid man-made chemical" data-html="true" title="Darmstadti">
                                <div class="symbol">Ds</div>
                                <div class="number">110</div>
                            </td>
                            <td class="unknow-property solid man-made chemical" data-html="true" title="Roentgeni">
                                <div class="symbol">Rg</div>
                                <div class="number">111</div>
                            </td>
                            <td class="transition-metal solid man-made chemical" data-html="true" title="Copernixi">
                                <div class="symbol">Cn</div>
                                <div class="number">112</div>
                            </td>
                            <td class="unknow-property solid man-made chemical" data-html="true" title="Ununtri">
                                <div class="symbol">Uut</div>
                                <div class="number">113</div>
                            </td>
                            <td class="unknow-property solid man-made chemical" data-html="true" title="Flerovi">
                                <div class="symbol">Fl</div>
                                <div class="number">114</div>
                            </td>
                            <td class="unknow-property solid man-made chemical" data-html="true" title="Ununpenti">
                                <div class="symbol">Uup</div>
                                <div class="number">115</div>
                            </td>
                            <td class="unknow-property solid man-made chemical" data-html="true" title="Livermori">
                                <div class="symbol">Lv</div>
                                <div class="number">116</div>
                            </td>
                            <td class="unknow-property solid man-made chemical" data-html="true" title="Ununsepti">
                                <div class="symbol">Uus</div>
                                <div class="number">117</div>
                            </td>
                            <td class="unknow-property solid man-made chemical" data-html="true" title="Ununocti">
                                <div class="symbol">Uuo</div>
                                <div class="number">118</div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="20"></td>

                        </tr>
                        <tr>
                            <th class="text-center" colspan="3">Nhóm lantan *</th>
                            <td class="transition-metal solid nature chemical" data-html="true" title="Lantan">
                                <div class="symbol">La</div>
                                <div class="number">57</div>
                            </td>
                            <td class="lantan solid nature chemical" data-html="true" title="Xeri">
                                <div class="symbol">Ce</div>
                                <div class="number">58</div>
                            </td>
                            <td class="lantan solid nature chemical" data-html="true" title="Praseodymi">
                                <div class="symbol">Pr</div>
                                <div class="number">59</div>
                            </td>
                            <td class="lantan solid nature chemical" data-html="true" title="Neodymi">
                                <div class="symbol">Nd</div>
                                <div class="number">60</div>
                            </td>
                            <td class="lantan solid born-late chemical" data-html="true" title="Promethi">
                                <div class="symbol">Pm</div>
                                <div class="number">61</div>
                            </td>
                            <td class="lantan solid nature chemical" data-html="true" title="Samari">
                                <div class="symbol">Sm</div>
                                <div class="number">62</div>
                            </td>
                            <td class="lantan solid nature chemical" data-html="true" title="Europi">
                                <div class="symbol">Eu</div>
                                <div class="number">63</div>
                            </td>
                            <td class="lantan solid nature chemical" data-html="true" title="Gadolini">
                                <div class="symbol">Gd</div>
                                <div class="number">64</div>
                            </td>
                            <td class="lantan solid nature chemical" data-html="true" title="Terbi">
                                <div class="symbol">Tb</div>
                                <div class="number">65</div>
                            </td>
                            <td class="lantan solid nature chemical" data-html="true" title="Dysprosi">
                                <div class="symbol">Dy</div>
                                <div class="number">66</div>
                            </td>
                            <td class="lantan solid nature chemical" data-html="true" title="Holmi">
                                <div class="symbol">Ho</div>
                                <div class="number">67</div>
                            </td>

                            <td class="lantan solid nature chemical" data-html="true" title="Erbi">
                                <div class="symbol">Er</div>
                                <div class="number">68</div>
                            </td>
                            <td class="lantan solid nature chemical" data-html="true" title="Thuli">
                                <div class="symbol">Tm</div>
                                <div class="number">69</div>
                            </td>
                            <td class="lantan solid nature chemical" data-html="true" title="Ytterbi">
                                <div class="symbol">Yb</div>
                                <div class="number">70</div>
                            </td>
                            <td class="lantan solid nature chemical" data-html="true" title="Luteti">
                                <div class="symbol">Lu</div>
                                <div class="number">71</div>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center" colspan="3">Nhóm actini **</th>
                            <td class="transition-metal solid born-late chemical" data-html="true" title="Actini">
                                <div class="symbol">Ac</div>
                                <div class="number">89</div>
                            </td>
                            <td class="actini solid nature chemical" data-html="true" title="Thori">
                                <div class="symbol">Th</div>
                                <div class="number">90</div>
                            </td>
                            <td class="actini solid nature chemical" data-html="true" title="Protactini">
                                <div class="symbol">Pa</div>
                                <div class="number">91</div>
                            </td>
                            <td class="actini solid nature chemical" data-html="true" title="Urani">
                                <div class="symbol">U</div>
                                <div class="number">92</div>
                            </td>
                            <td class="actini solid born-late chemical" data-html="true" title="Neptuni">
                                <div class="symbol">Np</div>
                                <div class="number">93</div>
                            </td>
                            <td class="actini solid nature chemical" data-html="true" title="Plutoni">
                                <div class="symbol">Pu</div>
                                <div class="number">94</div>
                            </td>
                            <td class="actini solid man-made chemical" data-html="true" title="Americi">
                                <div class="symbol">Am</div>
                                <div class="number">95</div>
                            </td>
                            <td class="actini solid man-made chemical" data-html="true" title="Curi">
                                <div class="symbol">Cm</div>
                                <div class="number">96</div>
                            </td>
                            <td class="actini solid man-made chemical" data-html="true" title="Berkeli">
                                <div class="symbol">Bk</div>
                                <div class="number">97</div>
                            </td>
                            <td class="actini solid man-made chemical" data-html="true" title="Californi">
                                <div class="symbol">Cf</div>
                                <div class="number">98</div>
                            </td>
                            <td class="actini solid man-made chemical" data-html="true" title="Einsteini">
                                <div class="symbol">Es</div>
                                <div class="number">99</div>
                            </td>
                            <td class="actini solid man-made chemical" data-html="true" title="Fermi">
                                <div class="symbol">Fm</div>
                                <div class="number">100</div>
                            </td>
                            <td class="actini solid man-made chemical" data-html="true" title="Mendelevi">
                                <div class="symbol">Md</div>
                                <div class="number">101</div>
                            </td>
                            <td class="actini solid man-made chemical" data-html="true" title="Nobeli">
                                <div class="symbol">No</div>
                                <div class="number">102</div>
                            </td>
                            <td class="actini solid man-made chemical" data-html="true" title="Lawrenci">
                                <div class="symbol">Lr</div>
                                <div class="number">103</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="pt-4"></div>
        <div class="des1">
            <p style="color: #4e4d4d;font-weight: 300;">
                Các nhóm cùng gốc trong bảng tuần hoàn</p>
            <div class="table-responsive">
                <table class="w-100">
                    <tr>
                        <td class="alkali-metal">Kim loại kiềm</td>
                        <td class="alkaline-earth-metal">Kim loại kiềm thổ</td>
                        <td class="lantan">Nhóm Lantan</td>
                        <td class="actini">Nhóm actini</td>
                        <td class="transition-metal">Kim loại chuyển tiếp</td>
                    </tr>
                    <tr>
                        <td class="weak-metal">Kim loại yếu</td>
                        <td class="half-metal">Á kim</td>
                        <td class="non-metal">Phi kim</td>
                        <td class="halogen">Halogen</td>
                        <td class="rare-gas">Khí trơ</td>
                    </tr>
                    <tr>
                        <td class="unknow-property">Thuộc tính hóa học không rõ</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="pt-3"></div>
        <div class="des2">
            <p>Trạng thái ở nhiệt độ và áp suất tiêu chuẩn</p>
            <ul>
                <li>Màu số nguyên tử <font color="#FF0000">đỏ</font> là chất khí ở nhiệt độ và áp suất tiêu chuẩn</li>
                <li>Màu số nguyên tử <font color="#00AA00">lục</font> là chất lỏng ở nhiệt độ và áp suất tiêu chuẩn</li>
                <li>Màu số nguyên tử <font color="#000000">đen</font> là chất rắn ở nhiệt độ và áp suất tiêu chuẩn</li>
            </ul>
        </div>
        <div class="des3 text-justify">
            <p>Tỷ lệ xuất hiện tự nhiên</p>
            <ul>
                <li class="pb-2">
                    <div style="border:solid 1px black;padding:1px;">Viền liền:  có đồng vị già hơn Trái Đất (chất nguyên thủy)
                    </div>
                </li>
                <li class="pb-2">
                    <div style="border:dashed 1px black;padding:1px;">Viền gạch gạch:thường sinh ra từ phản ứng phân rã các nguyên tố khác, không có đồng vị già hơn Trái Đất (hiện tượng hóa học)
                    </div>
                </li>
                <li class="pb-2">
                    <div style="border:dotted 1px black;padding:1px;">Viền chấm chấm: tạo ra trong phòng thí nghiệm (nguyên tố nhân tạo)
                    </div>
                </li>
                <li class="pb-2">
                    <div style="border:none;padding:1px;">Không có viền: chưa tìm thấy</div>
                </li>
            </ul>
            <p> Nguyên tắc sắp xếp các nguyên tố trong bảng tuần hoàn hóa học:</p>
            <p class="font-weight-normal" style="font-size: 0.9rem"> - Các nguyên tố trong bảng tuần hoàn được sắp xếp theo chiều tăng của điện tích hạt nhân (từ trái sang phải, từ trên xuống dưới)<br>
                - Các nguyên tố có cùng số lớp e xếp vào cùng 1 hàng (chu kì) <br>
                - Các nguyên tố có cấu hình e tương tự nhau được xếp vào cùng 1 cột (nhóm). </p>
            <p class="font-weight-bold" style="font-size: 0.9rem"> Cấu tạo bảng tuần hoàn </p>
            <p class="font-weight-normal" style="font-size: 0.9rem">1. Ô nguyên tố <br>
                - Mỗi nguyên tố hóa học chiếm 1 ô trong bảng tuần hoàn được gọi là ô nguyên tố. <br>
                - Số thứ tự ô nguyên tố = số hiệu nguyên tử của nguyên tố (= số e = số p = số đơn vị điện tích hạt nhân).<br>
                2. Chu kì<br>
                - Chu kì là dãy các nguyên tố mà nguyên tử của chúng có cùng số lớp e, được xếp theo chiều tăng dần của điện tích hạt nhân).<br>
                - Số thứ tự chu kì = số lớp e. <br>
                - Bảng tuần hoàn hiện có 7 chu kì được đánh số từ 1 đến 7:<br>
                + Chu kì 1,2,3: chu kì nhỏ <br>
                + Chu kì 4,5,6,7: chu kì lớn <br>
                + Chu kì 7 chưa hoàn thành <br>
                3. Nhóm nguyên tố <br>
                - Nhóm nguyên tố là tập hợp các nguyên tố mà nguyên tử có cấu hình e tương tự nhau do đó có tính chất hóa học gần giống nhau và được xếp thành 1 cột <br>
                - Có 2 loại nhóm nguyên tố là nhóm A và nhóm B <br>
                4. Khối nguyên tố (block) <br>
                - Các nguyên tố trong bảng tuần hoàn thuộc 4 khối: khối s, khối p, khối d và khối f. <br>
                - e cuối cùng điền vào  phân lớp nào (theo thứ tự mức năng lượng) thì nguyên tố thuộc khối đó.</p>
        </div>
        <p class="last-content text-center">Hãy sử dụng bảng tuần hoàn thật hiệu quả nhé!   </p>
        <div class="container pb-4">
            <div class="fb-like d-inline-block" style="margin-left: 50%;transform: translateX(-50%);" data-href="<?php echo url()->current(); ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
        </div>
    </section>
@endsection
@section('after-scripts')
    <script src="{{ url('frontend/js/equation_menu.js') }}"></script>
    <script src="{{ url('frontend/js/periodic_table.js') }}"></script>
    <script src="{{ url('frontend/js/social_button.js') }}"></script>
@endsection
