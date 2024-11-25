import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import ExamScreenLayout from "@/Layouts/ExamScreenLayout";
import { Head, useForm } from "@inertiajs/react";

export default function Instructions({ studentData }) {
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
					<div className="grid lg:grid-cols-7 grid-cols-1 gap-4">
						{/* <pre>{JSON.stringify(data, undefined, 2)}</pre> */}
						<div className="col-span-4">
							<div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
								<div className="sm:px-6 py-3 px-4">
									<h3 className="text-gray-900 font-semibold text-lg leading-5">
										Student Details
									</h3>
									<p className="text-gray-500 text-sm leading-6 max-w-3xl mt-1">
										Personal details and application.
									</p>
								</div>
								<div className="border-t border-gray-200 pb-40">
									<dl>
										<div className="sm:px-6 sm:gap-4 sm:grid sm:grid-cols-3 py-2 px-4 hover:bg-green-50">
											<dt className="text-gray-900 font-medium leading-5">
												Student Name
											</dt>
											<dd className="sm:mt-0 sm:col-span-2 text-gray-700 leading-6 mt-1">
												{studentData.data.student_name}
											</dd>
										</div>
										<div className="sm:px-6 sm:gap-4 sm:grid sm:grid-cols-3 py-4 px-4">
											<dt className="text-gray-900 font-medium leading-5">
												Student Name
											</dt>
											<dd className="sm:mt-0 sm:col-span-2 text-gray-700 leading-6 mt-1">
												Student Name
											</dd>
										</div>
									</dl>
								</div>
							</div>
						</div>
						<div className="col-span-3">
							<div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
								<div className="sm:px-6 py-3 px-4">
									<h3 className="text-gray-900 font-semibold text-base leading-5">
										School Details
									</h3>
									<p className="text-gray-500 text-sm leading-6 max-w-3xl mt-1">
										School Details
									</p>
								</div>
								<div className="border-t border-gray-200">
									<dl>
										<div className="sm:px-6 sm:gap-4 sm:grid sm:grid-cols-3 py-6 px-4">
											<dt className="text-gray-900 font-medium text-sm leading-5">
												Student Name
											</dt>
											<dd className="sm:mt-0 sm:col-span-2 text-gray-700 text-sm leading-6 mt-1">
												Student Name
											</dd>
										</div>
									</dl>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div className="pb-8">
				<div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
					<div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
						<div className="p-6 text-gray-900">
							<form onSubmit={submit}>
								<h3 className="text-gray-900 font-semibold text-base leading-5">
									Instructions
								</h3>

								<div className="flex items-start relative pt-5">
									<div className="flex leading-6 items-center">
										<input
											id="terms"
											name="terms"
											type="checkbox"
											className="text-indigo-600 border-red-600 rounded w-4 h-4"
											onClick={(e) => setData("terms", e.target.checked)}
										/>
									</div>
									<div className="text-base leading-4 ms-3 ">
										<InputLabel htmlFor="terms" className="">
											<div>I have read all rules.</div>
										</InputLabel>
									</div>
								</div>

								<div>
									<InputError message={errors.terms} className="mt-2" />
								</div>

								<div className="text-center">
									<PrimaryButton type="submit" className="mt-3">
										Start Exam
									</PrimaryButton>
								</div>
							</form>
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
