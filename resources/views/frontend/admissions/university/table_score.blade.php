 <div class="desktop-content">
        <table class="table table-bordered">
            <thead>
            <tr style="font-weight:400;background-color:#cecece1f">
                <th scope="col" class="text-center">STT</th>
                <th scope="col" class="text-center">Mã ngành</th>
                <th scope="col" class="text-center">Tên ngành</th>
                <th scope="col" class="text-center">Tổ hợp môn</th>
                <th scope="col" class="text-center">Điểm chuẩn</th>
                <th scope="col" class="text-center">Ghi chú</th>

            </tr>
            </thead>
            <tbody>
            @foreach($scores as $key => $score)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $score->code }}</td>
                    <td>{{ $score->name }}</td>
                    <td>{{ $score->group_subject }}</td>
                    <td>{{ $score->point }}</td>
                    <td>{{ $score->note }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="mobile-content">
        <ul class="list-unstyled" style="border-top:1px solid #d7d8d9;font-size:13px">
            @foreach($scores as $score)
                <li style="border-bottom: 1px solid #d7d8d9;
    padding: 5px 10px;
    line-height: 20px;">Mã ngành: {{ $score->code }} <br> Tên ngành: <span style="color:#14a9e3; font-weight:500">{{ $score->name }}</span>  <br>Tổ hợp môn: {{ $score->group_subject }} - Điểm chuẩn NV1: {{ $score->point }} {{ $score->note }}
                </li>
            @endforeach
        </ul>
    </div>