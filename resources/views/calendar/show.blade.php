@extends('layout')

@section('content')
    <div class="container">
        <h1>Reservacion</h1>
        <h1>{{ Session::get('room_id') }}</h1>




        @if ($reservations->count() > 0)
        <h2>Reservaciones existentes:</h2>

        @php
            $currentMonth = null;
            $currentYear = null;
            $calendar = [];
        @endphp

        @foreach ($reservations as $reservation)
            @php
                $month = date('F', strtotime($reservation->time_from));
                $year = date('Y', strtotime($reservation->time_from));

                $calendar[$year][$month][] = $reservation;
            @endphp
        @endforeach

        @foreach ($calendar as $year => $months)
            <div class="year">
                <h3>{{ $year }}</h3>
                <div class="calendar">
                    @foreach ($months as $month => $reservations)
                        <div class="month">
                            <h4>{{ $month }}</h4>
                            <table>
                                <thead>
                                    <tr>
                                        <th>D</th>
                                        <th>L</th>
                                        <th>M</th>
                                        <th>M</th>
                                        <th>J</th>
                                        <th>V</th>
                                        <th>S</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $firstDay = date('N', strtotime($year.'-'.$month.'-01'));
                                        $totalDays = date('t', strtotime($year.'-'.$month.'-01'));
                                        $currentDay = 1;
                                        $weekDay = 1;
                                    @endphp
                                    <tr>
                                        @while ($weekDay < $firstDay)
                                            <td></td>
                                            @php
                                                $weekDay++;
                                            @endphp
                                        @endwhile
                                        @while ($currentDay <= $totalDays)
                                            <td>
                                                <span>{{ $currentDay }}</span>
                                                @foreach ($reservations as $reservation)
                                                    @php
                                                        $startDay = date('j', strtotime($reservation->time_from));
                                                        $endDay = date('j', strtotime($reservation->time_to));
                                                    @endphp
                                                    @if ($currentDay >= $startDay && $currentDay <= $endDay)
                                                        <div class="reservation">
                                                            <span class="reserved-text">Ocupado</span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </td>
                                            @php
                                                $currentDay++;
                                                $weekDay++;
                                            @endphp
                                            @if ($weekDay > 7)
                                                @php
                                                    $weekDay = 1;
                                                @endphp
                                                </tr><tr>
                                            @endif
                                        @endwhile
                                        @while ($weekDay <= 7)
                                            <td></td>
                                            @php
                                                $weekDay++;
                                            @endphp
                                        @endwhile
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @else
        <p>No hay reservaciones existentes para este cuarto.</p>
    @endif
@endsection
