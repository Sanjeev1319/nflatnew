import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";

export default function Dashboard({ success, route }) {
	return (
		<AuthenticatedLayout
			header={
				<h2 className="text-xl font-semibold leading-tight text-gray-800">
					Dashboard
				</h2>
			}
		>
			<Head title="Dashboard" />

			{success && (
				<div className="pt-12">
					<div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
						<div className="overflow-hidden shadow-sm sm:rounded-lg">
							<div class="bg-indigo-900 text-center py-4 lg:px-4">
								<div
									class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex"
									role="alert"
								>
									<span class="flex rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3">
										New
									</span>
									<span class="font-semibold mr-2 text-left flex-auto">
										{success}{" "}
										{route && (
											<span>
												<a
													href={route}
													className="text-green-200 hover:text-green-100"
												>
													Click here to view list.
												</a>
											</span>
										)}
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			)}

			<div className="py-12">
				<div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
					<div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
						<div className="p-6 text-gray-900">You're logged in!</div>
					</div>
				</div>
			</div>
		</AuthenticatedLayout>
	);
}
