import java.util.*;
public class sum_matrix
{
	public static void main(String args[])
	{
		
		Scanner sc= new Scanner(System.in);
		System.out.println("Enter a row and column ");
		int row=sc.nextInt();
		int col=sc.nextInt();
		int arr[][]=new int[row][col];
		for(int i=0; i<row; i++)
		{
			for(int j=0; j<col; j++)
			{	
				System.out.println("Enter Value = ");
				arr[i][j]=sc.nextInt();
			}
		}
		System.out.println("Entered Values = ");
		for(int i=0; i<row; i++)
		{
			for(int j=0; j<col; j++)
			{
				System.out.print(arr[i][j]+"\t");
			}
			System.out.println();
		}
		System.out.println("sum of matrix");
		for (int i=0; i<row; i++)
		{
			int sum=0;
			for(int j=0; j<col; j++)
			{
				sum=sum+arr[i][j];
			}
			System.out.println("Sum of Row "+(i+1)+" = "+sum);
		}
		for (int j=0; j<col; j++)
		{
			int sum=0;
			for(int i=0; i<row; i++)
			{
				sum=sum+arr[i][j];
			}
			System.out.println("Sum of Column "+(j+1)+" = "+sum);
		}
	}
}
