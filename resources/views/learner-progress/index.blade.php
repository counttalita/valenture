@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6" x-data="learnerProgress()" x-init="init()">
    <h1 class="text-2xl font-bold mb-6">Learner Progress Dashboard</h1>
    <div class="grid gap-6">
        <!-- Learners List -->
        <template x-if="learners.length === 0">
            <div class="text-gray-500">No learners found.</div>
        </template>
        <template x-for="learner in learners" :key="learner.id">
            <div class="bg-white rounded shadow p-4">
                <h2 class="font-semibold text-lg" x-text="learner.first_name + ' ' + learner.last_name"></h2>
                <div class="ml-4 mt-2">
                    <template x-if="learner.courses.length === 0">
                        <div class="text-gray-400 text-sm">No courses enrolled.</div>
                    </template>
                    <template x-for="course in learner.courses" :key="course.id">
                        <div class="flex justify-between text-sm py-1">
                            <span x-text="course.name"></span>
                            <span class="font-mono" x-text="course.pivot.progress_percentage + '%' "></span>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </div>
</div>

<!-- Alpine.js logic -->
<script>
function learnerProgress() {
    return {
        learners: [],
        async init() {
            const res = await fetch('/api/learners');
            this.learners = await res.json();
        }
    }
}
</script>
@endsection
