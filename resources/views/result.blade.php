@extends('layouts.app')

@section('title', '- Hasil Sorting')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Hasil Pengurutan dengan {{ $algorithm == 'bubble' ? 'Bubble Sort' : 'Selection Sort' }}</h5>
                    <a href="{{ route('index') }}" class="btn btn-sm btn-outline-light">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Array Awal:</h5>
                        <div class="array-display">
                            @foreach ($originalArray as $value)
                                <span class="array-item">{{ $value }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5>Array Terurut:</h5>
                        <div class="array-display">
                            @foreach ($sortedArray as $value)
                                <span class="array-item">{{ $value }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <h5 class="mt-4">Visualisasi Pengurutan:</h5>
                
                <div class="legend">
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #4a6fa5;"></div>
                        <span>Belum diurutkan</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #ff9800;"></div>
                        <span>Sedang Dibandingkan</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #4caf50;"></div>
                        <span>sudah diurutkan</span>
                    </div>
                </div>
                
                <div id="visualization-container">
                    <div class="array-container" id="array-container"></div>
                    
                    <div class="d-flex justify-content-center gap-2 mt-3">
                        <button id="prev-btn" class="btn btn-outline-secondary">
                            <i class="bi bi-chevron-left"></i> Sebelumnya
                        </button>
                        <button id="next-btn" class="btn btn-outline-secondary">
                            Selanjutnya <i class="bi bi-chevron-right"></i>
                        </button>
                        <button id="play-btn" class="btn btn-primary">
                            <i class="bi bi-play-fill"></i> Play
                        </button>
                        <button id="pause-btn" class="btn btn-outline-secondary">
                            <i class="bi bi-pause-fill"></i> Pause
                        </button>
                    </div>
                    
                    <div class="speed-control mt-3">
                        <label for="speed-slider" class="form-label">Kecepatan:</label>
                        <input type="range" class="form-range" id="speed-slider" min="1" max="10" value="5">
                    </div>
                    
                    <div class="progress mt-3">
                        <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                    </div>
                    
                    <div class="text-center mt-3">
                        <span id="step-info">Langkah 0 dari {{ count($steps) - 1 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data dari controller
        const sortingSteps = @json($steps);
        
        // Elements
        const arrayContainer = document.getElementById('array-container');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const playBtn = document.getElementById('play-btn');
        const pauseBtn = document.getElementById('pause-btn');
        const speedSlider = document.getElementById('speed-slider');
        const progressBar = document.getElementById('progress-bar');
        const stepInfo = document.getElementById('step-info');
        
        // Variables
        let currentStep = 0;
        let animationInterval;
        let speed = 500; // ms
        
        // Initialize visualization
        function initArray() {
            // Reset visualization
            arrayContainer.innerHTML = '';
            
            // Get initial array
            const initialArray = sortingSteps[0].array;
            
            // Find max value for scaling
            const maxVal = Math.max(...initialArray);
            
            // Create array bars
            initialArray.forEach((val, idx) => {
                const bar = document.createElement('div');
                bar.className = 'array-bar';
                bar.style.height = `${(val / maxVal) * 250}px`;
                bar.setAttribute('data-value', val);
                arrayContainer.appendChild(bar);
            });
            
            // Render first step
            renderStep(0);
        }
        
        // Render current step
        function renderStep(stepIndex) {
            if (stepIndex < 0 || stepIndex >= sortingSteps.length) return;
            
            const step = sortingSteps[stepIndex];
            const bars = document.querySelectorAll('.array-bar');
            
            // Update heights and classes
            step.array.forEach((val, idx) => {
                const bar = bars[idx];
                const maxVal = Math.max(...step.array);
                
                bar.style.height = `${(val / maxVal) * 250}px`;
                bar.setAttribute('data-value', val);
                
                // Reset classes
                bar.className = 'array-bar';
                
                // Apply comparing class
                if (step.comparing.includes(idx)) {
                    bar.classList.add('comparing');
                }
                
                // Apply sorted class
                if (step.sorted.includes(idx)) {
                    bar.classList.add('sorted');
                }
            });
            
            // Update progress bar
            const progress = (stepIndex / (sortingSteps.length - 1)) * 100;
            progressBar.style.width = `${progress}%`;
            
            // Update step info
            stepInfo.textContent = `Langkah ${stepIndex} dari ${sortingSteps.length - 1}`;
        }
        
        // Next step function
        function nextStep() {
            if (currentStep < sortingSteps.length - 1) {
                currentStep++;
                renderStep(currentStep);
            } else {
                clearInterval(animationInterval);
                playBtn.textContent = 'Play Ulang';
            }
        }
        
        // Previous step function
        function prevStep() {
            if (currentStep > 0) {
                currentStep--;
                renderStep(currentStep);
            }
        }
        
        // Auto play function
        function autoPlay() {
            clearInterval(animationInterval);
            
            // If at the end, reset to beginning
            if (currentStep >= sortingSteps.length - 1) {
                currentStep = 0;
                renderStep(currentStep);
            }
            
            speed = 1100 - (speedSlider.value * 100); // Invert speed value
            animationInterval = setInterval(nextStep, speed);
            
            // Update button text
            playBtn.textContent = 'Play';
        }
        
        // Pause function
        function pausePlay() {
            clearInterval(animationInterval);
        }
        
        // Event listeners
        prevBtn.addEventListener('click', function() {
            pausePlay();
            prevStep();
        });
        
        nextBtn.addEventListener('click', function() {
            pausePlay();
            nextStep();
        });
        
        playBtn.addEventListener('click', function() {
            autoPlay();
        });
        
        pauseBtn.addEventListener('click', function() {
            pausePlay();
        });
        
        speedSlider.addEventListener('input', function() {
            if (animationInterval) {
                pausePlay();
                autoPlay();
            }
        });
        
        // Initialize with first step
        initArray();
    });
</script>
@endsection