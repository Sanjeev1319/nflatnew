import Pagination from "@/Components/Pagination";
import TableHeading from "@/Components/TableHeading";
import { Link, router } from "@inertiajs/react";
import { useEffect, useState } from "react";

export default function DataTable({ tableValues, count }) {
	// const deleteQuestion = (question) => {
	// 	if (!window.confirm("Are you sure you want to delete the question")) {
	// 		return;
	// 	}
	// router.delete(
	// 	route("question.destroy", {
	// 		question: question.id,
	// 	})
	// );
	// };

	// Track the current page and items per page
	const [page, setPage] = useState(null);
	const itemsPerPage = 20; // Set the number of items per page

	useEffect(() => {
		// Get the query string from the URL
		const queryParams = new URLSearchParams(window.location.search);

		// Check for the "page" parameter
		const pageParam = queryParams.get("page");

		// Set the page parameter in the state
		setPage(pageParam);
	}, []);

	// Calculate the starting index based on the current page
	const startingIndex = page ? (parseInt(page, 10) - 1) * itemsPerPage + 1 : 1;

	return (
		<>
			<div className="overflow-auto rounded-lg">
				<table className="w-full text-sm text-left text-gray-700 dark:text-slate-400">
					<thead className="text-xs text-white dark:text-lime-300 border-b-2 border-violet-500 dark:bg-slate-600 uppercase bg-violet-950">
						<tr className="text-nowrap text-xs">
							<TableHeading name={"id"}>#</TableHeading>
							<TableHeading name={"student_uuid"}>ID</TableHeading>
							<TableHeading name={"student_name"}>Name</TableHeading>
							<TableHeading name={"student_class"}>Class</TableHeading>
							<TableHeading name={"date_of_birth"}>Date of Birth</TableHeading>
							<TableHeading name={"gender"}>Gender</TableHeading>
							<TableHeading name={"parent_name"}>Parent Name</TableHeading>
							<TableHeading name={"parent_email_id"}>
								Parent Email ID
							</TableHeading>
							<TableHeading name={"parent_mobile_number"}>
								Parent Mobile
							</TableHeading>
							<TableHeading name={"password"}>Password</TableHeading>
							<th className="px-3 py-3 text-center">Action</th>
						</tr>
					</thead>
					<tbody className="">
						{tableValues.data.map((student, index) => (
							<tr
								key={student.id}
								className="border-violet-400 border-b hover:bg-violet-100"
							>
								<td className="px-3 py-3">{startingIndex + index}</td>
								<td className="px-3 py-3">{student.student_uuid}</td>
								<td className="px-3 py-3">{student.student_name}</td>
								<td className="px-3 py-3">
									{student.student_class} - {student.student_section}
								</td>
								<td className="px-3 py-3">{student.date_of_birth}</td>
								<td className="px-3 py-3">{student.gender}</td>
								<td className="px-3 py-3">{student.parent_name}</td>
								<td className="px-3 py-3">
									{student.parent_email_id || "N/A"}
								</td>
								<td className="px-3 py-3">
									{student.parent_mobile_number || "N/A"}
								</td>
								<td className="px-3 py-3">{student.show_pass}</td>
								<td className="text-center">Edit</td>
							</tr>
						))}
					</tbody>
				</table>
				{/* <pre>{JSON.stringify(tableValues, undefined, 2)}</pre> */}
			</div>
			{typeof tableValues.meta === "undefined" ||
			typeof tableValues.meta.links === "undefined" ? null : (
				<Pagination links={tableValues.meta.links} count={count} />
			)}
		</>
	);
}
