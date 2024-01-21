<?php
 
use function Laravel\Folio\{name,middleware};
use function Livewire\Volt\{rules, state, form, mount};
use App\Livewire\Forms\WorkScheduleForm;
use App\Models\Employee;
use App\Models\Counter;

middleware(['auth']);
name('human-resource.work-schedule.create');
form(WorkScheduleForm::class);

state(['employees', 'counters']);

mount(function (){
    $this->employees = Employee::pluck('name');
    $this->counters = Counter::pluck('name');
});


$submit = function (){
    $this->validate();

    try {
        $this->form->store();
        session()->flash('success', 'Data berhasil ditambah');
        $this->redirect('');
    } catch (\Throwable $th) {
        session()->flash('error', $th->getMessage());
        $this->redirect('');
    }

};

?>


<x-layouts.app subheaderTitle="" >
    @volt
    <div wire:ignore class="container" >
        <div class="card card-custom card-strecth" id="card-s" >
            <div class="card-header">
                <span class="card-title">
                    <div class="card-label">Buat Jadwal</div>
                </span>
            </div>
            <div class="card-body">
                <div class="card-scroll">
                    <div id="excel-container"></div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="button" class="btn btn-primary save">
                    Simpan
                </button>
            </div>
        </div>
    </div>

    <script >

        document.addEventListener('livewire:navigated', () => {

            function getFormattedDate() {
                const today = new Date();
                
                const day = String(today.getDate()).padStart(2, '0');
                const month = String(today.getMonth() + 1).padStart(2, '0'); // Month dimulai dari 0, jadi perlu ditambah 1
                const year = today.getFullYear();
        
                return `${day}/${month}/${year}`;
            }

            function saveSchedule(data){
                $.ajax({
                    url: "{{ route('workschedule.store') }}",
                    method: 'POST',
                    data: {
                        schedules: data
                    },
                    beforeSend: () => {
                        Swal.fire({
                            title: "<div class='spinner-border text-info' role='status'></div>",
                            text: "Menyimpan data...",
                            showConfirmButton: false,
                            allowOutsideClick: false,
                        });
                    },
                    success: res => {
                        console.log(res)
                        Swal.fire({
                            icon: 'success',
                            title: "Berhasil!",
                            text: 'Data berhasil disimpan',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    },
                    error: err => {
                        Swal.fire({
                            icon: 'error',
                            title: "Gagal",
                            text: err.responseJSON.message ?? 'Kesalahan internal',
                            showCloseButton: true,
                            showConfirmButton: false,
                        });
                    },
                })
            }

            var StretchCard=function() {
                // Private properties
                var _element;

                // Private functions
                var _init=function() {
                    var scroll=KTUtil.find(_element, '.card-scroll');
                    var cardBody=KTUtil.find(_element, '.card-body');
                    var cardHeader=KTUtil.find(_element, '.card-header');
                    var cardFooter=KTUtil.find(_element, '.card-footer');

                    var height=KTLayoutContent.getHeight();

                    height=height - parseInt(KTUtil.actualHeight(cardFooter));
                    height=height - parseInt(KTUtil.actualHeight(cardHeader));

                    height=height - parseInt(KTUtil.css(_element, 'marginTop')) - parseInt(KTUtil.css(_element, 'marginBottom'));
                    height=height - parseInt(KTUtil.css(_element, 'paddingTop')) - parseInt(KTUtil.css(_element, 'paddingBottom'));

                    height=height - parseInt(KTUtil.css(cardBody, 'paddingTop')) - parseInt(KTUtil.css(cardBody, 'paddingBottom'));
                    height=height - parseInt(KTUtil.css(cardBody, 'marginTop')) - parseInt(KTUtil.css(cardBody, 'marginBottom'));

                    height=height - 3;

                    KTUtil.css(scroll, 'height', height + 'px');
                }

                // Public methods
                return {
                init: function(id) {
                _element=KTUtil.getById(id);

                if ( !_element) {
                    return;
                }

                // Initialize
                _init();

                // Re-calculate on window resize
                KTUtil.addResizeHandler(function() {
                    _init();
                    
                    }
                );
                },

                update: function() {
                    _init();
                }
            };
        }();

        function getTableHeight(){

            var _element=KTUtil.getById('card-s');
            var scroll=KTUtil.find(_element, '.card-scroll');
            var cardBody=KTUtil.find(_element, '.card-body');
            var cardHeader=KTUtil.find(_element, '.card-header');
            var cardFooter=KTUtil.find(_element, '.card-footer');

            var height=KTLayoutContent.getHeight();

            height=height - parseInt(KTUtil.actualHeight(cardFooter));
            height=height - parseInt(KTUtil.actualHeight(cardHeader));

            height=height - parseInt(KTUtil.css(_element, 'marginTop')) - parseInt(KTUtil.css(_element, 'marginBottom'));
            height=height - parseInt(KTUtil.css(_element, 'paddingTop')) - parseInt(KTUtil.css(_element, 'paddingBottom'));

            height=height - parseInt(KTUtil.css(cardBody, 'paddingTop')) - parseInt(KTUtil.css(cardBody, 'paddingBottom'));
            height=height - parseInt(KTUtil.css(cardBody, 'marginTop')) - parseInt(KTUtil.css(cardBody, 'marginBottom'));

            height=height - 3;

            return height;
        }

            StretchCard.init('card-s')

            const container = document.querySelector('#excel-container');

            const hot = new Handsontable(container, {
                columns: [
                    {
                        width: 50,
                        type: 'date',
                        dateFormat: 'DD/MM/YYYY',
                        correctFormat: true,
                        defaultDate: getFormattedDate(),
                        datePickerConfig: {
                            // First day of the week (0: Sunday, 1: Monday, etc)
                            firstDay: 0,
                            showWeekNumber: true,
                        }
                    },
                    {
                        width: 50,
                        type: 'autocomplete',
                        source: {{ Js::from($employees) }},
                        strict: true
                    },
                    {
                        width: 50,
                        type: 'autocomplete',
                        source: {{ Js::from($counters) }},
                        strict: true
                    },
                    {
                        width: 50,
                        type: 'time',
                        timeFormat: 'HH:mm',
                        correctFormat: true
                    },
                    {
                        width: 50,
                        type: 'time',
                        timeFormat: 'HH:mm',
                        correctFormat: true
                    },
                ],
                rowHeaders: true,
                colHeaders: ['Tanggal', 'Karyawan', 'Counter', 'Waktu Masuk', 'Waktu Keluar'],
                contextMenu: true,
                height: getTableHeight(),
                rowHeights: 30,
                startRows: {{ Js::from(count($employees)) }},
                manualRowMove: true,
                stretchH: 'all', 
                fillHandle: {
                    autoInsertRow: true
                },
                licenseKey: 'non-commercial-and-evaluation' // for non-commercial use only
            });

            document.querySelector('.save').addEventListener('click', () =>{
                saveSchedule(hot.getData())
            })

        })

    </script>

    @endvolt
</x-layouts.app>
