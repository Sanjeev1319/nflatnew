import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import ExamScreenLayout from "@/Layouts/ExamScreenLayout";
import { Head, useForm } from "@inertiajs/react";

export default function Instructions({ student_uuid }) {
	const { data, setData, post, processing, errors, reset } = useForm({
		terms: false,
	});

	const submit = (e) => {
		e.preventDefault();

		post(route("student.startExam"));
	};

	return (
		<ExamScreenLayout>
			<Head title="Instructions" />

			<div className="py-8">
				<div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
					<div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
						<div className="p-6 text-gray-900">
							<pre></pre>
						</div>
					</div>
				</div>
			</div>
			<div className="pb-8">
				<div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
					<div className="overflow-hidden bg-white shadow-sm sm:rounded-lg"></div>
				</div>
			</div>
		</ExamScreenLayout>
	);
}
