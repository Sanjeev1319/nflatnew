import { Link, usePage } from "@inertiajs/react";
import { useEffect, useState } from "react";

export default function Pagination({ links, count }) {
	const [page, setPage] = useState(1); // Default to page 1
	const [startIndex, setStartIndex] = useState(1);
	const [endIndex, setEndIndex] = useState(20);
	const totalItems = count; // Assuming you know total number of items

	useEffect(() => {
		const queryParams = new URLSearchParams(window.location.search);
		const pageParam = queryParams.get("page");
		const currentPage = pageParam ? parseInt(pageParam, 10) : 1;
		setPage(currentPage);

		// Calculate the start and end indices for the current page
		const itemsPerPage = 20;
		const start = (currentPage - 1) * itemsPerPage + 1;
		const end = Math.min(currentPage * itemsPerPage, totalItems);

		setStartIndex(start);
		setEndIndex(end);
	}, [window.location.search]);

	return (
		<>
			<nav className="text-center mt-4">
				{links.map((link) => (
					<Link
						preserveScroll
						href={link.url || ""}
						key={link.label}
						className={
							"inner-block py-2 px-3 rounded-lg text-xs mx-1 " +
							(link.active ? "bg-lime-400 text-black font-bold " : " ") +
							(!link.url
								? "!text-gray-500 cursor-not-allowed "
								: " hover:bg-lime-400 hover:text-black hover:font-bold ")
						}
						dangerouslySetInnerHTML={{ __html: link.label }}
					></Link>
				))}
				{/* <pre>{JSON.stringify(links, undefined, 2)}</pre> */}
			</nav>
			<div>
				<p>
					Showing items {startIndex} to {endIndex} out of {totalItems}
				</p>
				{/* Render your list of students here */}
			</div>
		</>
	);
}
