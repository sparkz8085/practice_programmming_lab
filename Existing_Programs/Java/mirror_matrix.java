import java .util.*;
public class mirror_matrix
{
	public static void main(String args[])
	{
		Scanner sc=new Scanner(System.in);
		System.out.println("enter row size: ");
		int row=sc.nextInt();
		System.out.println("enter column");
		int col=sc.nextInt();
		int arr[][]=new int[row][col];
		int ind=0;
		for (int i=0;i<row;i++)
		{
			for (int j=0;j<col;j++)
			{
				System.out.println("enter value"+ind+": ");
				arr[i][j]=sc.nextInt();
				ind++;
			}
		}	
		System.out.println("entered values = ");
		for(int i=0; i<row; i++)
		{
			for(int j=0; j<col; j++)
			{
				System.out.print(arr[i][j]+"\t");
			}
			System.out.println();
		}
		for (int j=0;j<col;j++)
		{
			int temp=arr[j][0];
			arr[j][0]=arr[j][row-1];
			arr[j][row-1]=temp;
		}
		System.out.println("after swapping first and last columns = ");
		for(int i=0; i<row; i++)
		{
			for(int j=0; j<col; j++)
			{
				System.out.print(arr[i][j]+"\t");
			}
			System.out.println();
		}
	}
}

